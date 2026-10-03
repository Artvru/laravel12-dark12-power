<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = $this->customerQuery($request)
            ->withCount('purchaseHistories')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('customers.index', [
            'customers' => $customers,
            'search' => trim((string) $request->query('search', '')),
        ]);
    }

    public function create()
    {
        return view('customers.form', ['customer' => new Customer()]);
    }

    public function store(Request $request)
    {
        Customer::create($this->validatedCustomer($request));

        return redirect()->route('customers.index')->with('success', 'เพิ่มข้อมูลลูกค้าแล้ว');
    }

    public function show(Customer $customer)
    {
        $customer->load('purchaseHistories');

        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.form', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $customer->update($this->validatedCustomer($request, $customer));

        return redirect()->route('customers.show', $customer)->with('success', 'บันทึกการแก้ไขแล้ว');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'ลบข้อมูลลูกค้าแล้ว');
    }

    public function storePurchase(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'description' => ['required', 'string', 'max:2000'],
            'amount' => ['required', 'numeric', 'min:0', 'max:999999999.99'],
            'purchase_date' => ['required', 'date'],
        ]);

        $customer->purchaseHistories()->create($data);

        return redirect()->route('customers.show', $customer)->with('success', 'เพิ่มประวัติการซื้อแล้ว');
    }

    public function destroyPurchase(Customer $customer, int $purchaseHistory)
    {
        $customer->purchaseHistories()->findOrFail($purchaseHistory)->delete();

        return redirect()->route('customers.show', $customer)->with('success', 'ลบประวัติการซื้อแล้ว');
    }

    public function export(Request $request)
    {
        $customers = $this->customerQuery($request)->with('purchaseHistories')->orderBy('name')->get();
        $filename = 'customers-'.now()->format('Ymd-His').'.csv';

        return response()->streamDownload(function () use ($customers) {
            $output = fopen('php://output', 'w');
            fwrite($output, "\xEF\xBB\xBF"); // UTF-8 BOM for Excel.
            fputcsv($output, ['Name', 'Email', 'Phone', 'Address', 'Purchase history', 'Amount', 'Purchase date']);

            foreach ($customers as $customer) {
                if ($customer->purchaseHistories->isEmpty()) {
                    fputcsv($output, [
                        $this->safeCsvCell($customer->name),
                        $this->safeCsvCell($customer->email),
                        $this->safeCsvCell($customer->phone),
                        $this->safeCsvCell($customer->address),
                        '', '', '',
                    ]);
                    continue;
                }

                foreach ($customer->purchaseHistories as $purchase) {
                    fputcsv($output, [
                        $this->safeCsvCell($customer->name),
                        $this->safeCsvCell($customer->email),
                        $this->safeCsvCell($customer->phone),
                        $this->safeCsvCell($customer->address),
                        $this->safeCsvCell($purchase->description),
                        $purchase->amount,
                        $purchase->purchase_date->format('Y-m-d'),
                    ]);
                }
            }

            fclose($output);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function customerQuery(Request $request): Builder
    {
        $search = trim((string) $request->query('search', ''));

        return Customer::query()->when($search !== '', function (Builder $query) use ($search) {
            $query->where(function (Builder $query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        });
    }

    private function validatedCustomer(Request $request, ?Customer $customer = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('customers', 'email')->ignore($customer?->id)],
            'phone' => ['required', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:2000'],
        ]);
    }

    private function safeCsvCell(?string $value): string
    {
        $value = $value ?? '';

        return preg_match('/^[\s]*[=+@\-\\t\\r]/u', $value) ? "'".$value : $value;
    }
}
