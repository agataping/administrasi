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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" >
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

<script>
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


  // Fungsi untuk menambah input Laba Rugi
  document.getElementById('addSubkategori').addEventListener('click', function() 
  {
    const subkategoriContainer = document.getElementById('subkategori-container');
    const subkategoriItem = document.createElement('div');
    subkategoriItem.classList.add('subkategori-item', 'mb-2');
    const newSubkategoriInput = document.createElement('input');
    newSubkategoriInput.type = 'text';
    newSubkategoriInput.name = 'sub[]';
    newSubkategoriInput.classList.add('form-control');
    newSubkategoriInput.placeholder = 'Sub Kategori';
    const deleteButton = document.createElement('button');
    deleteButton.type = 'button';
    deleteButton.classList.add('btn', 'btn-danger', 'btn-sm', 'ms-2');
    deleteButton.textContent = 'Hapus';
    
    deleteButton.addEventListener('click', function() {
      subkategoriContainer.removeChild(subkategoriItem);  // Menghapus div yang berisi input dan tombol
    });
    
    // Menambahkan input dan tombol ke dalam subkategoriItem
    subkategoriItem.appendChild(newSubkategoriInput);
    subkategoriItem.appendChild(deleteButton);

    // Menambahkan subkategoriItem ke dalam subkategoriContainer
// Fungsi untuk menghitung nilai actual kategori (induk) berdasarkan subkategori
function updateCategoryActual(categoryId) {
    let totalActual = 0;

    // Ambil semua input dengan kelas 'actual-ytd' yang memiliki parent_id yang sesuai dengan kategori induk
    const subcategories = document.querySelectorAll(`.actual-ytd[data-parent-id="${categoryId}"]`);
    
    // Jumlahkan nilai actual dari setiap subkategori
    subcategories.forEach(subcategory => {
        totalActual += parseFloat(subcategory.value) || 0; // Gunakan 0 jika nilai input kosong atau tidak valid
    });

    // Update nilai total actual di kategori (induk)
    const categoryInput = document.getElementById(`categoryActual_${categoryId}`);
    categoryInput.value = totalActual.toFixed(2); // Menampilkan hasil dengan 2 angka desimal
}


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

  // Menangani perubahan pada kategori
  $('#kategori').on('change', function() {
    const kategoriText = $('#kategori option:selected').text();
    $('#kategori-mining').val(kategoriText);
    $('#form-input').slideDown();
  });

  // Menangani perubahan pada CS Mining
  $('#csmining').on('change', function() {
    const csminingText = $('#csmining option:selected').text();
    $('#cs-mining').val(csminingText);
    $('#form-inputan-cs').slideDown();
  });

  // Fungsi untuk menghitung total
  document.addEventListener("DOMContentLoaded", function() {
  // Fungsi untuk menghitung total
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

</script>
