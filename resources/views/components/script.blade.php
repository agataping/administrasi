<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Template Javascript -->
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
{{-- toastr --}}
<!-- SweetAlert -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

<script>
  function confirmDelete(event) {
    event.preventDefault(); // Prevent the form from submitting immediately

    let confirmation = confirm("Are you sure you want to delete this data?");

    if (confirmation) {
      event.target.closest("form").submit(); // Submit the form if the user confirms
    }
  }

  //search table
  function searchTable() {
    let input = document.getElementById("searchInput");
    let filter = input.value.toLowerCase();
    let table = document.getElementById("myTable");
    let tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {
        let td = tr[i].getElementsByTagName("td");
        let rowVisible = false;

        for (let j = 0; j < td.length; j++) {
            if (td[j]) {
                let txtValue = td[j].textContent || td[j].innerText;
                console.log("Checking:", txtValue); // Debugging
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    rowVisible = true;
                    break;
                }
            }
        }

        tr[i].style.display = rowVisible ? "" : "none";
    }
}

  //select option serach
  $(document).ready(function() {
    $('#kategori').select2({
      placeholder: "-- Select Category --",
      allowClear: true,
      maximumInputLength: 10, // Gantilah dengan angka yang sesuai
      dropdownCssClass: "custom-dropdown-scroll" // Pisahkan menjadi properti sendiri
    });
  });


  document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById("note");

    // Fungsi untuk menambahkan nomor pada setiap baris
    function addLineNumbers(text) {
      const lines = text.split("\n");
      const numberedLines = lines.map((line, index) => {
        return `${index + 1}. ${line}`;
      });
      return numberedLines.join("\n");
    }

    // Saat halaman dimuat, tambahkan nomor pada textarea jika ada catatan
    window.addEventListener('load', () => {
      textarea.value = addLineNumbers(textarea.value); // Menambahkan nomor saat halaman dimuat
    });

    // Fungsi untuk memperbarui nomor baris saat ada perubahan dalam textarea
    function updateLineNumbers() {
      let lines = textarea.value.split("\n");
      lines = lines.map((line, index) => `${index + 1}. ${line.replace(/^\d+\.\s*/, '')}`); // Menghapus nomor lama dan menambahkan nomor baru
      textarea.value = lines.join("\n");
    }

    // Menambahkan nomor setiap kali ada input atau enter
    textarea.addEventListener('input', updateLineNumbers);

    // Menambahkan nomor baris sebelum form disubmit
    const form = document.querySelector('form'); // Ambil form
    form.addEventListener('submit', function(event) {
      textarea.value = addLineNumbers(textarea.value); // Tambahkan nomor sebelum submit
    });
  });


  // Fungsi untuk menghitung quantity fulfillment
  function hitungQuantityFulfillment() {
    const plan = parseFloat(document.getElementById('Fullfillment_plan').value);
    const actual = parseFloat(document.getElementById('Fullfillment_actual').value);
    const hasilInput = document.getElementById('quantity-fulfillment');

    if (plan !== 0 && !isNaN(plan) && !isNaN(actual)) {
      const quantityFulfillment = (actual / plan) * 100;
      hasilInput.value = Math.round(quantityFulfillment) + "%";
    } else {
      hasilInput.value = '';
    }
  }


  // Fungsi untuk menghitung quality
  function hitungQuality() {
    const pouActual = parseFloat(document.getElementById('POU_POU_actual').value);
    const leadershipActual = parseFloat(document.getElementById('Leadership_actual').value);
    const hseActual = parseFloat(document.getElementById('HSE_actual').value);
    const improvementActual = parseFloat(document.getElementById('Improvement_actual').value);

    const pouPlan = parseFloat(document.getElementById('POU_POU_plan').value);
    const leadershipPlan = parseFloat(document.getElementById('Leadership_plan').value);
    const hsePlan = parseFloat(document.getElementById('HSE_plan').value);
    const improvementPlan = parseFloat(document.getElementById('Improvement_plan').value);

    if (
      !isNaN(pouActual) && !isNaN(leadershipActual) && !isNaN(hseActual) && !isNaN(improvementActual) &&
      !isNaN(pouPlan) && !isNaN(leadershipPlan) && !isNaN(hsePlan) && !isNaN(improvementPlan) &&
      pouPlan !== 0 && leadershipPlan !== 0 && hsePlan !== 0 && improvementPlan !== 0
    ) {
      const hasil = (((pouActual / pouPlan) + (leadershipActual / leadershipPlan) + (hseActual / hsePlan) + (improvementActual / improvementPlan)) / 4) * 100;
      document.getElementById('Quality').value = Math.round(hasil) + "%";
    } else {
      document.getElementById('Quality').value = "Invalid input";
    }
  }

  // Menjalankan fungsi hitungQuality saat konten dimuat
  document.addEventListener('DOMContentLoaded', function() {
    hitungQuality();
  });



  // Fungsi untuk menambah input Kategori
  let inputCounterKategori = 1;

  function tambahInputKategori() {
    inputCounterKategori++;
    const inputKategori = document.getElementById('kategori');
    const newRow = document.createElement('div');
    newRow.innerHTML = `
      <div class="row g-3">
        <div class="col-sm-2">
          <label for="kategori_${inputCounterKategori}" class="form-label">Kategori ${inputCounterKategori}</label>
          <input type="text" class="form-control" id="kategori_${inputCounterKategori}" placeholder="" required name="kategori[]">
        </div>
        <button type="button" class="btn btn-danger" onclick="hapusInputKategori(this)">Hapus</button>
      </div>
    `;
    inputKategori.appendChild(newRow);
  }


  // Fungsi untuk menambah input Kategori CS Mining
  let inputCounterKategoricsmining = 1;

  function tambahInputkategoricsmining() {
    inputCounterKategoricsmining++;
    const inputkategoricsmining = document.getElementById('kategoricsmining');
    const newRow = document.createElement('div');
    newRow.innerHTML = `
      <div class="row g-3">
        <div class="col-sm-2">
          <label for="kategoricsmining_${inputCounterKategoricsmining}" class="form-label">Kategoricsmining ${inputCounterKategoricsmining}</label>
          <input type="text" class="form-control" id="kategoricsmining_${inputCounterKategoricsmining}" placeholder="" required name="kategori[]">
        </div>
        <button type="button" class="btn btn-danger" onclick="hapusInputkategoricsmining(this)">Hapus</button>
      </div>
    `;
    inputkategoricsmining.appendChild(newRow);
  }

  // Mining
  $('#kategori').on('change', function() {
    const kategoriText = $('#kategori option:selected').text();
    $('#kategori-mining').val(kategoriText);
    $('#form-input').slideDown();
  });

  //  pada CS Mining
  $('#csmining').on('change', function() {
    const csminingText = $('#csmining option:selected').text();
    $('#cs-mining').val(csminingText);
    $('#form-inputan-cs').slideDown();
  });

  // Fungsi untuk menghitung total
  document.addEventListener("DOMContentLoaded", function() {
    // Fungsi untuk menghitung total ifra 
    function total() {
      const kelayakanBangunan = parseFloat(document.getElementById('kelayakan-bangunan').value);
      const kelengkapan = parseFloat(document.getElementById('kelengkapan').value);
      const kebersihan = parseFloat(document.getElementById('Kebersihan').value);

      const hasilInput = document.getElementById('total');

      // Pastikan input yang dimasukkan adalah angka yang valid
      if (isNaN(kelayakanBangunan) || isNaN(kelengkapan) || isNaN(kebersihan)) {
        hasilInput.value = ''; // Kosongkan hasil jika ada input yang tidak valid
        return;
      }

      // Lakukan perhitungan jika input valid
      const total = Math.round((kelayakanBangunan + kelengkapan + kebersihan) / 3);
      hasilInput.value = total + "%";
    }

    // Menambahkan event listener untuk input yang otomatis memanggil fungsi total saat ada perubahan
    document.getElementById('kelayakan-bangunan').addEventListener('input', total);
    document.getElementById('kelengkapan').addEventListener('input', total);
    document.getElementById('Kebersihan').addEventListener('input', total);
  });

  $(document).ready(function() {
    $('.select2').select2();
  });
  document.getElementById('csmining').addEventListener('change', function() {
    document.getElementById('mining').value = this.value;
  });



  //laba rugi
  document.addEventListener('DOMContentLoaded', function() {
    const actualInputs = document.querySelectorAll('.actual-ytd');
    // Fungsi untuk menghitung total actual YTD pada kategori
    function calculateActualYtd() {
      actualInputs.forEach(input => {
        input.addEventListener('input', function() {
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
    const hasilPercentage = document.getElementById('percentage_' + descriptionId);

    if (PlanY !== 0 && !isNaN(PlanY) && !isNaN(Dev)) {
      const Percentage = (Dev / PlanY) * 100;
      hasilPercentage.value = Math.round(Percentage) + "%";

    } else {
      hasilPercentage.value = '';
    }
  }
  document.addEventListener('DOMContentLoaded', function() {
    calculatePercentage();
  });

  document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById("note");

    // Fungsi untuk menambahkan nomor pada setiap baris
    function addLineNumbers(text) {
      const lines = text.split("\n");
      const numberedLines = lines.map((line, index) => {
        return `${index + 1}. ${line}`;
      });
      return numberedLines.join("\n");
    }

    // Saat halaman dimuat, tambahkan nomor pada textarea jika ada catatan
    window.addEventListener('load', () => {
      textarea.value = addLineNumbers(textarea.value); // Menambahkan nomor saat halaman dimuat
    });

    // Fungsi untuk memperbarui nomor baris saat ada perubahan dalam textarea
    function updateLineNumbers() {
      let lines = textarea.value.split("\n");
      lines = lines.map((line, index) => `${index + 1}. ${line.replace(/^\d+\.\s*/, '')}`); // Menghapus nomor lama dan menambahkan nomor baru
      textarea.value = lines.join("\n");
    }

    // Menambahkan nomor setiap kali ada input atau enter
    textarea.addEventListener('input', updateLineNumbers);

    // Menambahkan nomor baris sebelum form disubmit
    const form = document.querySelector('form'); // Ambil form
    form.addEventListener('submit', function(event) {
      textarea.value = addLineNumbers(textarea.value); // Tambahkan nomor sebelum submit
    });
  });



</script>