@extends('template.main')
@extends('components.style')

@section('title', 'Finansial Perspektif')
@section('content')

<div class="container-fluid mt-4">
    <div class="card w-100">
        <div class="card-body">
            <div class="col-12">
                <h2 class="mb-3">Finansial Perspektif</h2>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

  
                <form method="POST" action="{{ url('/updateLabarugi') }}">
                    @csrf
                    <input type="hidden" name="updated_by_name" value="{{ Auth::user()->username }}">

                    <table class="table table-bordered">
                        <thead style="background-color:rgb(6, 99, 120)" class="text-white">
                            <tr>
                                <th rowspan="2" style="vertical-align: middle;">category</th>
                                <th rowspan="2" style="vertical-align: middle;">Plan YTD</th>
                                <th rowspan="2" style="vertical-align: middle;">Vertical Analisys</th>
                                <th rowspan="2" style="vertical-align: middle;">Actual YTD</th>
                                <th rowspan="2" style="vertical-align: middle;">Vertical Analisys</th>
                                <th rowspan="2" style="vertical-align: middle;">Deviations</th>
                                <th rowspan="2" style="vertical-align: middle;">Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($structuredData as $category)
                                <tr>
                                <td><strong>{{ $category['name'] }}</strong>
                                <input type="hidden" name="values[{{ $category['id'] }}][description_DescriptionName]" value="{{ $category['name'] }}">

                            </td>
                                @if ($category['id'] == '3') 
                                <td colspan="">
                                    <input type="number" 
                                    name="values[{{ $category['id'] }}][PlaYtd]"
                                    value="{{ old('values.' . $category['id'] . '.PlaYtd', $category['PlaYtd'] ?? '') }}"
                                    id="planYtd_{{ $category['id'] }}"
                                    oninput="calculateVerticalAnalysis({{ $category['id'] }}); 
                                        HitungDev({{ $category['id'] }});
                                        calculatePercentage({{ $category['id'] }})">
                                    
                                </td>
                                <td></td>
                                        

                                @endif
                                @if ($category['id'] != 3 && !$category['parent_id']) 
                                <td colspan="">
                                        <input type="number" id="planYtd_{{ $category['id'] }}" class="form-control" 
                                        data-parent-id="{{ $category['parent_id'] }}" 
                                        name="values[{{ $category['id'] }}][PlaYtd]" 
                                        value="{{ old('values.' . $category['id'] . '.PlaYtd', $category['PlaYtd'] ?? '') }}"

                                        oninput="calculateVerticalAnalysis({{ $category['id'] }}); HitungDev({{ $category['id'] }});
                                        calculatePercentage({{ $category['id'] }})">

                                </td>
                                @endif

                                @if (in_array($category['id'], [6, 15, 22]))                                    
                                <td>
                                    <input type="text" id="verticalAnalisys1_{{ $category['id'] }}" class="form-control" 
                                        data-parent-id="{{ $category['parent_id'] }}" 
                                         name="values[{{ $category['id'] }}][VerticalAnalisys1]" 
                                        value="{{ old('values.' . $category['id'] . '.VerticalAnalisys1', $category['VerticalAnalisys1'] ?? '') }}"
                                        readonly>

                                </td>
                                @endif
                                
                                @if (!$category['parent_id'])
                                <td> 
                                    
                                    <input type="number" id="categoryTotal_{{ $category['id'] }}" 
                                    class="form-control" 
                                    name="values[{{ $category['id'] }}][Actualytd]" 
                                    value="{{ old('values.' . $category['id'] . '.categoryTotal', $category['Actualytd'] ?? '') }}" 

                                    readonly
                                    placeholder="Total"
                                    oninput="HitungDev({{ $category['id'] }})">
                                    
                                </td>
                                @endif
                                
 

                                @if (!$category['parent_id'])
                                <td>
                                    <input type="number" id="verticalAnalisys2_{{ $category['id'] }}" class="form-control" 
                                    data-parent-id="{{ $category['parent_id'] }}" 
                                    name="values[{{ $category['id'] }}][VerticalAnalisys]" 
                                    value="{{ old('values.' . $category['id'] . '.VerticalAnalisys') }}">                                
                                </td>
                                @endif
                                
                                @if (!$category['parent_id'])
                                <td>
                                    <input type="number" id="deviation_{{ $category['id'] }}" class="form-control" 
                                    data-parent-id="{{ $category['parent_id'] }}" 
                                    name="values[{{ $category['id'] }}][Deviation]" 
                                    value="{{ old('values.' . $category['id'] . '.Deviation', $category['Deviation'] ?? '') }}"                                    oninput="calculatePercentage({{ $category['id'] }})"
                                    readonly>
                                </td>
                                @endif

                                @if (!$category['parent_id'])
                                <td>
                                    <input type="text" id="percentage_{{ $category['id'] }}" class="form-control" 
                                    data-parent-id="{{ $category['parent_id'] }}" 
                                    name="values[{{ $category['id'] }}][Percentage]" 
                                    value="{{ old('values.' . $category['id'] . '.Percentage', $category['Percentage'] ?? '') }}"
                                    readonly>
                                </td>
                                @endif

                            </tr>
                            @foreach ($category['subcategories'] as $subcategory)
                            <tr>
                                <td><strong>{{ $subcategory['name'] }}</strong>
                                <input type="hidden" name="values[{{ $subcategory['id'] }}][description_DescriptionName]" value="{{ $subcategory['name'] }}">


                            </td>
                                <td></td>
                                <td></td>
                                
                                <!-- Pengecekan apakah 'parent_id' ada sebelum mengaksesnya -->
                                @if (($subcategory['parent_id']))
                                <td colspan="" style="padding-left: 20px;">
                                <input type="number" 
                                id="actualYtd_{{ $subcategory['id'] }}" 
                                class="form-control actual-ytd" 
                                data-parent-id="{{ $subcategory['parent_id'] }}" 
                                name="values[{{ $subcategory['id'] }}][Actualytd]" 
                                value="{{ old('values.' . $subcategory['id'] . '.Actualytd', $subcategory['Actualytd'] ?? '') }}">
                                

                                
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            @endif
                        </tr>
                        @endforeach
                        
                            

                            

                            @endforeach
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">Save</button>
                    
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const actualInputs = document.querySelectorAll('.actual-ytd'); 
    // Fungsi untuk menghitung total actual YTD pada kategori
    function calculateActualYtd() {
        actualInputs.forEach(input => {
            input.addEventListener('input', function () {
                const parentId = input.getAttribute('data-parent-id'); 
                let totalActualYtd = 0;

                document.querySelectorAll(`.actual-ytd[data-parent-id="${parentId}"]`).forEach(subInput => {
                    totalActualYtd += parseFloat(subInput.value) || 0;
                });

                const categoryTotalElem = document.querySelector(`#categoryTotal_${parentId}`);
                if (categoryTotalElem) {
                    categoryTotalElem.value = totalActualYtd; 
                }
            });
        });
    }

    calculateActualYtd();
});

function calculateVerticalAnalysis(descriptionId) {
    // Ambil nilai dari input Plan YTD untuk kategori yang sesuai
    var planYtdElement = document.getElementById('planYtd_' + descriptionId);
    var verticalAnalisysElement = document.getElementById('verticalAnalisys1_' + descriptionId);

    // Periksa apakah elemen Plan YTD dan Vertical Analysis ada
    if (!planYtdElement || !verticalAnalisysElement) return;

    // Jika input planYtd kosong, set default ke 0
    var planYtd = planYtdElement.value.trim() !== '' ? 
    parseFloat(planYtdElement.value.trim().replace(/[^0-9.-]/g, '')) : 0;

    // Pastikan nilai Plan YTD diambil dengan benar
    if (planYtd > 0) {
        // Ambil nilai Plan YTD untuk kategori Revenue (kategori ID 3)
        var revenuePlanYtdElement = document.getElementById('planYtd_3');
        var revenuePlanYtd = revenuePlanYtdElement ? 
                             parseFloat(revenuePlanYtdElement.value.trim().replace(/[^0-9.-]/g, '')) : 1;

        // Hitung Vertical Analysis jika Revenue Plan YTD ada
        if (revenuePlanYtd !== 0) {
            var verticalAnalysis = (planYtd / revenuePlanYtd) * 100;
            verticalAnalisysElement.value = verticalAnalysis.toFixed(2) + '%';
        } else {
            verticalAnalisysElement.value = '';
        }
    } else {
        verticalAnalisysElement.value = '';
    }
}






// Fungsi untuk menghitung Deviation
function HitungDev(descriptionId) {
    const actual = parseFloat(document.getElementById('categoryTotal_' + descriptionId).value);
    const plan = parseFloat(document.getElementById('planYtd_' + descriptionId).value);
    const hasilInput = document.getElementById('deviation_' + descriptionId);

    // Menghitung deviasi berdasarkan nilai actual dan plan
    if (!isNaN(plan) && !isNaN(actual)) {
        const deviation = plan - actual; // Deviation adalah selisih antara actual dan plan
        hasilInput.value = deviation; // Menampilkan deviasi pada input
    } else {
        hasilInput.value = ''; // Jika nilai kosong atau tidak valid
    }
    }
    document.addEventListener('DOMContentLoaded', function() {
    HitungDev();
  });


        // Fungsi untuk menghitung Percentage
    function calculatePercentage(descriptionId) {
            const PlanY = parseFloat(document.getElementById('planYtd_' + descriptionId).value);
            const Dev = parseFloat(document.getElementById('deviation_' + descriptionId).value);
            const hasilPercentage = document.getElementById('percentage_'+ descriptionId);
      
      if (PlanY !== 0 && !isNaN(PlanY) && !isNaN(Dev)) {
        const Percentage = (Dev / PlanY) * 100;
        hasilPercentage.value = Math.round(Percentage) +"%";
        
      } else {
        hasilPercentage.value = '';
      }
    }
    document.addEventListener('DOMContentLoaded', function() {
        calculatePercentage();
    });

</script>