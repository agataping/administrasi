<script>
    let subcategoryIndex = 1; // untuk menambahkan input dinamis dengan indeks yang berbeda

document.getElementById('add-subcategory').addEventListener('click', function() {
    // Menambahkan form input baru untuk subkategori
    const container = document.getElementById('Neraca-container');
    const newSubcategory = document.createElement('div');
    newSubcategory.classList.add('subcategory-input');
    
    newSubcategory.innerHTML = `
        <div>
            <label for="name">Nama Subkategori</label>
            <input type="text" name="Neraca[${subcategoryIndex}][description]" required>
        </div>
        <div>
            <label for="nominal">Nominal</label>
            <input type="number" name="Neraca[${subcategoryIndex}][nominal]" required>
        </div>
        <div>
            <label for="category_id">Kategori</label>
            <select name="Neraca[${subcategoryIndex}][category_id]" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->description }}</option>
                @endforeach
            </select>
        </div>
    `;

    container.appendChild(newSubcategory);

    subcategoryIndex++;
});

</script>