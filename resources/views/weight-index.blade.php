<x-weight title="รายการน้ำหนัก">
    <main class="main">
        <section class="section py-5">
            <div class="container">

                <!-- Success Message -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <h2 class="mb-4">📈 รายการติดตามน้ำหนัก</h2>

                <!-- Google Chart -->
                <div class="row mb-5">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">แนวโน้มน้ำหนัก</h5>
                                <div id="curve_chart" style="width: 100%; height: 400px"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">ข้อมูลทั้งหมด</h5>
                                
                                @if ($weights->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>#</th>
                                                    <th>วันที่</th>
                                                    <th>น้ำหนัก (kg)</th>
                                                    <th>หมายเหตุ</th>
                                                    <th>การจัดการ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($weights as $index => $weight)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($weight->date)->format('d/m/Y') }}</td>
                                                        <td><strong>{{ number_format($weight->weight, 2) }}</strong></td>
                                                        <td>{{ $weight->notes ?? '-' }}</td>
                                                        <td>
                                                            <a href="{{ route('weight.edit', $weight->id) }}" 
                                                                class="btn btn-sm btn-warning">
                                                                ✏️ แก้ไข
                                                            </a>
                                                            <form action="{{ route('weight.delete', $weight->id) }}" 
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger"
                                                                    onclick="return confirm('ยืนยันการลบ?')">
                                                                    🗑️ ลบ
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-info">
                                        ยังไม่มีข้อมูลน้ำหนัก <a href="{{ route('weight.form') }}">เพิ่มข้อมูลเลย</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </main>

    <!-- Google Chart Script -->
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['วันที่', 'น้ำหนัก (kg)'],
                @foreach ($weights->sortBy('date') as $weight)
                    ['{{ \Carbon\Carbon::parse($weight->date)->format('d/m/Y') }}', {{ $weight->weight }}],
                @endforeach
            ]);

            var options = {
                title: 'แนวโน้มการเปลี่ยนแปลงน้ำหนัก',
                curveType: 'function',
                legend: { position: 'bottom' },
                hAxis: {
                    title: 'วันที่'
                },
                vAxis: {
                    title: 'น้ำหนัก (กิโลกรัม)'
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
            chart.draw(data, options);
        }
    </script>
</x-weight>