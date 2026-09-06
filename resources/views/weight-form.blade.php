<x-weight title="{{ isset($weight) ? 'แก้ไขน้ำหนัก' : 'เพิ่มน้ำหนัก' }}">
    <main class="main">
        <section class="section py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <h4 class="alert-heading">ข้อผิดพลาด!</h4>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <h2 class="mb-4">
                            @if(isset($weight))
                                แก้ไขน้ำหนัก
                            @else
                                เพิ่มข้อมูลน้ำหนัก
                            @endif
                        </h2>

                        <form action="@if(isset($weight)){{ route('weight.update', $weight->id) }}@else{{ route('weight.submit') }}@endif" 
                              method="POST">
                            @csrf
                            @if(isset($weight))
                                @method('PUT')
                            @endif

                            <div class="mb-3">
                                <label for="date" class="form-label">วันที่บันทึก</label>
                                <input type="date" class="form-control" id="date" name="date" 
                                    value="{{ old('date', isset($weight) ? $weight->date : '') }}" required>
                                @error('date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="weight" class="form-label">น้ำหนัก (กิโลกรัม)</label>
                                <input type="number" class="form-control" id="weight" name="weight" 
                                    step="0.01" placeholder="เช่น 65.50"
                                    value="{{ old('weight', isset($weight) ? $weight->weight : '') }}" required>
                                @error('weight')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">หมายเหตุ</label>
                                <textarea class="form-control" id="notes" name="notes" 
                                    rows="3" placeholder="เพิ่มหมายเหตุ (ไม่บังคับ)">{{ old('notes', isset($weight) ? $weight->notes : '') }}</textarea>
                                @error('notes')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    @if(isset($weight))
                                        อัปเดตข้อมูล
                                    @else
                                        บันทึกน้ำหนัก
                                    @endif
                                </button>
                                <a href="{{ route('weight.index') }}" class="btn btn-secondary btn-lg">ยกเลิก</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </section>
    </main>
</x-weight>