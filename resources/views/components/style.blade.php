<style>
    .nav-item:hover .dropdown-menu {
        display: block;
    }

    .dropdown-menu .dropdown-item {
        text-transform: uppercase;
        font-optical-sizing: auto;
        font-size: 14px;
        font-style: normal;
        font-weight: ;
        color: rgb(255, 255, 255);
    }

    .dropdown-menu {
        background: rgba(62, 61, 61, 0.47) !important;
        backdrop-filter: blur(10px);
        border-radius: 8px;
        border: 2px solid rgba(0, 0, 0, 0.3);
    }
    .metric:hover {
        transform: scale(1.05);
        transition: 0.3s ease-in-out;
    }

    label {
        font-family: "Faustina", serif;
        font-optical-sizing: auto;
        font-weight: <weight>;
        font-style: normal;
    }

    td {
        font-family: 'Lato', sans-serif;
        font-size: 14px;
        color: #333;
        /* text-align: center; */
        padding: 8px;
        text-transform: capitalize;
        vertical-align: middle;
        border: 1px solid #ddd;
        background-color: rgb(0, 0, 0);
    }

    td.number {
        text-align: right;
        font-family: 'Courier New', monospace;
        font-weight: bold;
        text-align: end;
        color: black;
    }

    th {
        font-family: "Borel", cursive;
        font-weight: 400;
        font-style: normal;
        color: black;
        text-align: center;
        padding: 10px;
        border: 1px solidrgb(0, 0, 0);
        text-transform: uppercase;

    }

    h3 {
        font-family: "Lexend Deca", sans-serif;
        color: #2c3e50;
        margin-bottom: 20px;
        font-style: normal;
        text-transform: uppercase;

    }

    h2 {
        font-family: 'Anton', sans-serif;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 2px;/
    }

    @media (max-width: 768px) {
        nav {
            padding: 10px 20px;
        }

        .nav-item {
            margin-right: 10px;
        }

        .dropdown-menu {
            min-width: 150px;
        }

        h5 {
            font-size: 1rem;
        }

        .flex-shrink-0 {
            margin-left: 10px;
        }

        .dropdown-menu-end {
            width: auto;
        }
    }

    @media (min-width: 769px) {
        nav {
            padding: 15px 30px;
        }

        .nav-item {
            margin-right: 20px;

        }

        .dropdown-menu {
            min-width: 180px;

            h5 {
                font-size: 1.2rem;
            }
        }
    }

    .row {
        margin: 20px 0;
    }

    .col-sm-2 {
        background-color: #f8f9fa;
        /* Warna latar belakang lembut */
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
        border-color: rgb(21, 100, 22);
        box-shadow: 0 0 5px rgba(235, 250, 235, 0.5);
        outline: none;
    }

    select option {
        padding: 10px;
    }

    .btn-custom {
        display: block;
        padding: 15px;
        font-size: 18px;
        font-weight: bold;
        text-align: center;
        color: #fff;
        text-transform: uppercase;
        background: linear-gradient(45deg, rgb(30, 255, 10), rgb(6, 255, 85));
        border: none;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        background: linear-gradient(45deg, rgb(63, 212, 41), rgb(2, 232, 2));
    }

    .full-width-line {
        border: 0;
        height: 1px;
        background-color: #000;
        width: 100%;
    }

    .grid-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin: 20px 0;
    }

    .grid-item {
        text-align: center;
    }

    .cardcostum {
        transition: 0.3s;
        width: 300px;
        /* background-color: rgba(191, 191, 191, 0.92); */
        background-color: rgba(32, 31, 31, 0.82);

        /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */

        margin: 30px auto;
        padding: 20px;
        border-radius: 10px;
        position: relative;
        z-index: 3;
        font-size: 18px;
    }

    .cardcostum:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        transform: translateY(-10px);

    }

    .cardcost {
        color: white;
        text-align: center;
        margin: 0;
        font-size: 15px;

    }

    .percentage-box {
        background-color: rgb(255, 255, 255);
        color: #333;
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 5px;
        margin-top: auto;
        align-self: center;
    }

    .cardcostum .cardcost h4 {
        font-size: 12px !important;/ font-weight: normal;
    }

    .cardcostum .percentage-box {
        font-size: 12px !important;
        /* Paksa ukuran teks persentase */
    }


    .pagination {
        font-size: 0.900rem;
    }

    .pagination .page-link {
        padding: 0.25rem 0.5rem;
    }

    .pagination .page-item.active .page-link {
        background-color: #4CAF50;
        border-color: #4CAF50;
    }

    @media (max-width: 768px) {

        .cardcost h3,
        .cardcost h4 {
            font-size: 1.2rem;
        }

        .percentage-box h3 {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .percentage-box h3 {
            font-size: 1.2rem;
        }

        .cardcost h3,
        .cardcost h4 {
            font-size: 1rem;
        }
    }

    .button {
        background-color: rgb(0, 255, 42);
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
        font-weight: bold;
    }

    .button:hover {
        background-color: rgb(0, 200, 35);
    }


    .filter-form {
        display: flex;
        flex-direction: column;
        gap: 15px;
        padding: 15px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.11);
        border-radius: 10px;
        background: #fff;
        max-width: 500px;
        margin: auto;


    }

    .filter-form label {
        font-size: 14px;
        font-weight: bold;
        color: #333;

    }

    .filter-form select {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
        outline: none;
        transition: all 0.3s ease-in-out;
    }

    .filter-form select:focus {
        border-color: #388e3c;
        box-shadow: 0 0 5px rgba(56, 142, 60, 0.5);
    }

    .filter-form button {
        background-color: #388e3c;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        transition: 0.3s ease;
    }

    .filter-form button:hover {
        background-color: #2e7d32;
    }


    .filter-date {

        background: #ffffff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        max-width: 650px;
        padding: 15px 20px;
        margin: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .filter-date label {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        font-family: "Zain", sans-serif;
        font-weight: 700;
        font-style: normal;
        text-transform: uppercase;
    }

    .filter-date input {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        outline: none;
        transition: all 0.3s ease-in-out;
    }

    .filter-date input:focus {
        border-color: #388e3c;
        box-shadow: 0 0 5px rgba(56, 142, 60, 0.5);
    }

    .filter-date button {
        background-color: #388e3c;
        color: white;
        padding: 8px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        transition: 0.3s ease;
    }

    .filter-date button:hover {
        background-color: #2e7d32;
    }
</style>