<style>
    /* Tambahkan gaya untuk membuat form lebih menarik */
    .row {
        margin: 20px 0;
    }

    .col-sm-2 {
        background-color: #f8f9fa; /* Warna latar belakang lembut */
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    label {
        font-size: 16px;
        font-weight: bold;
        color: #333;
        display: block;
        margin-bottom: 8px;
    }

    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
        background-color: #fff;
        transition: all 0.3s ease;
    }

    select:focus {
        border-color:rgb(21, 100, 22);
        box-shadow: 0 0 5px rgba(235, 250, 235, 0.5);
        outline: none;
    }

    select option {
        padding: 10px;
    }
      .btn-custom {
        display: block;
        /* width: 100%; */
        padding: 15px;
        font-size: 18px;
        font-weight: bold;
        text-align: center;
        color: #fff;
        background: linear-gradient(45deg,rgb(30, 255, 10),rgb(6, 255, 85));
        border: none;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        background: linear-gradient(45deg,rgb(63, 212, 41),rgb(2, 232, 2));
    }
    .full-width-line {
    border: 0;
    height: 1px;
    background-color: #000;
    width: 100%;
}
.cardcostum {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  transition: 0.3s;
  width: 200px;
  width: 200px; /* Seragamkan ukuran */
  background-color: darkgreen;
  margin: 20px auto;
  padding: 20px;
  border-radius: 10px;
  position: relative;
  z-index: 3;
}
  .cardcostum:hover {
  box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
}

.cardcost {
  color: white;
  text-align: center;
  margin: 0; /* Hilangkan margin ekstra */
}

.percentage-box {
  background-color: green;
  color: white;
  font-weight: bold;
  padding: 5px 10px;
  border-radius: 5px;
  margin-top: auto; 
  align-self: center; 
}
</style>