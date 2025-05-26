<?php 
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background: #fff;">
    <h1>Welcome, <span><?= $_SESSION['name']; ?></span></h1>
    <button onclick="window.location.href='logout.php'">Logout</button>
</body>
</html> -->

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Perpustakaan - CRUD Buku dan Peminjaman</title>
  <link
    href="https://cdn.jsdelivr.net/npm/@picocss/pico@1.*/css/pico.min.css"
    rel="stylesheet"
  />
  <style>
    body {
      max-width: 960px;
      margin: 5rem auto 1rem; /* add top margin to avoid navbar overlap */
      padding: 0 1rem;
      scroll-behavior: smooth;
    }
     nav {
      position: fixed;
      top: 0;
      left: 0; /* ubah dari 50% ke 0 */
      width: 100%; /* pastikan lebar 100% */
      background: #ffffff; /* fully opaque white background */
      border-bottom: 2px solid #ccc; /* solid bottom border with light gray */
      box-shadow: none; /* remove shadow */
      z-index: 1000;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0.5rem 1rem;
    }
    nav a.brand {
      font-weight: 900;
      font-size: 1.3rem;
      letter-spacing: 2px;
      color: var(--primary);
      text-decoration: none;
    }
    nav ul {
      list-style: none;
      display: flex;
      gap: 1em;
      margin: 0;
      padding: 0;
    }
    nav ul li a {
      text-decoration: none;
      font-weight: 600;
      color: var(--gray-900);
      transition: color 0.2s ease-in-out;
    }
    nav ul li a:hover,
    nav ul li a:focus {
      color: var(--primary);
    }

    /* Struktur dasar */
#top {
  position: relative;
  height: 100vh;
  overflow: hidden;
}

.image-container {
  position: absolute;
  width: 100%;
  height: 100%;
  z-index: 1;
}

.header-image {
  position: absolute;
  width: 100%;
  height: 100%;
  object-fit: cover;
  opacity: 0;
  transition: opacity 1.5s ease-in-out;
}

.header-image.active {
  opacity: 1;
}

/* Overlay blend effect */
.overlay {
  position: relative;
  z-index: 2;
  width: 100%;
  height: 60%;
  background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5));
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
  color: white;
  padding: 1rem;
}

h1 {
  font-size: 3rem;
  margin: 0;
}

p {
  font-size: 1.5rem;
  margin-top: 0.5rem;
}

    header {
      position: relative;
      border-radius: 10px;
      overflow: hidden;
      margin-bottom: 2rem;
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
      height: 350px;
    }
    header .header-image {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 60%;
      object-fit: cover;
      opacity: 0;
      transition: opacity 1s ease-in-out;
      z-index: 0;
      mix-blend-mode: multiply;
      filter: brightness(0.6);
      border-radius: 10px;
    }
    header .header-image.active {
      opacity: 1;
      z-index: 1;
    }
    header .overlay {
  position: absolute;
  top: 10%;
  left: 0;
  width: 100%;
  height: 60%; /* atau 100% jika ingin full menutupi seluruh header */
  background: rgba(0, 0, 0, 0.25);
  color: white;
  z-index: 2;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  text-shadow: 0 2px 8px rgba(0, 0, 0, 0.8);
  padding: 1rem;
  border-radius: 10px;
}

    header h1 {
      font-size: 2.8rem;
      margin-bottom: 0.2rem;
      font-weight: 900;
      letter-spacing: 2px;
      line-height: 1.1;
    }
    header p {
      font-size: 1.3rem;
      font-style: italic;
      margin-top: 0;
      font-weight: 600;
      letter-spacing: 0.7px;
    }
    hgroup {
      margin-bottom: 0;
    }
    table {
      margin-top: 0.5rem;
      width: 100%;
      border-collapse: collapse;
    }
    table th,
    table td {
      padding: 0.5rem 0.75rem;
      border-bottom: 1px solid var(--gray-300);
      vertical-align: middle;
    }
    /* Category table specific */
    #categoryTable img {
      width: 48px;
      height: 48px;
      object-fit: cover;
      border-radius: 6px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }
    #bookForm select,
    #bookForm input {
      max-width: 100%;
    }
    /* Fix button container alignment for book action buttons */
    .action-buttons {
      display: flex;
      gap: 0.5rem;
      justify-content: center;
    }
    /* Adjust button size to be consistent */
    .action-buttons button {
      min-width: 70px;
    }
    /* Align the add book button with the table */
    #btnAddBook {
      margin-top: 0.5rem;
      margin-left: auto;
      display: block;
      min-width: 180px;
    }
    .status-available {
      color: #27ae60;
      font-weight: bold;
    }
    .status-unavailable {
      color: #c0392b;
      font-weight: bold;
    }
    section {
      margin-bottom: 2rem;
    }
    footer {
      text-align: center;
      padding: 1rem 0;
      color: var(--gray-600);
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <nav role="navigation" aria-label="Primary navigation">
    <a href="#top" class="brand">Perpustakaan</a>
    <ul>
      <li><a href="#categorySection">Kategori</a></li>
      <li><a href="#booksSection">Tabel Buku</a></li>
      <li><a href="#loanSection">Form Peminjaman</a></li>
      <li><a href="#loanListSection">Daftar Peminjaman</a></li>
    </ul>
  </nav>

  <header id="top">
  <div class="image-container">
    <img
      src="https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=1170&q=80"
      alt="Perpustakaan 1"
      class="header-image active"
    />
    <img
      src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1170&q=80"
      alt="Perpustakaan 2"
      class="header-image"
    />
    <img
      src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=1170&q=80"
      alt="Perpustakaan 3"
      class="header-image"
    />
  </div>

  <div class="overlay" role="banner">
    <hgroup>
      <h1>Welcome, <span><?= $_SESSION['name']; ?></span></h1>  
      <h1>Perpustakaan Digital</h1>
      <p>Membuka Dunia dengan Buku & Pengetahuan</p>
    </hgroup>
  </div>
</header>


  <main>
    <section id="categorySection">
      <h2>Daftar Kategori</h2>
      <table id="categoryTable" role="list"></table>
    </section>

    <section id="booksSection">
      <h2>Tabel Buku</h2>
      <table>
        <thead>
          <tr>
            <th>Judul Buku</th>
            <th>Kategori</th>
            <th>Status</th>
            <th style="min-width: 160px;">Aksi</th>
          </tr>
        </thead>
        <tbody id="booksTableBody"></tbody>
      </table>
      <button id="btnAddBook" class="contrast" type="button">Tambah Buku Baru</button>
    </section>

    <section id="loanSection">
      <h2>Formulir Pengajuan Peminjaman Buku</h2>
      <form id="loanForm">
        <label for="borrowerName">Nama Peminjam:</label>
        <input
          type="text"
          id="borrowerName"
          name="borrowerName"
          required
          placeholder="Masukkan nama peminjam"
        />

        <label for="bookSelect">Pilih Buku:</label>
        <select id="bookSelect" name="bookSelect" required>
          <option value="">-- Pilih buku --</option>
        </select>

        <label for="borrowDate">Tanggal Pinjam:</label>
        <input type="date" id="borrowDate" name="borrowDate" required min="" />

        <button type="submit" class="primary">Ajukan Peminjaman</button>
      </form>
    </section>

    <section id="loanListSection">
      <h2>Daftar Pengajuan Peminjaman</h2>
      <table>
        <thead>
          <tr>
            <th>Nama Peminjam</th>
            <th>Judul Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="loansTableBody"></tbody>
      </table>
    </section>

    <dialog id="bookDialog">
      <form method="dialog" id="bookForm">
        <h3 id="bookFormTitle">Tambah Buku</h3>
        <label for="bookTitle">Judul Buku:</label>
        <input
          type="text"
          id="bookTitle"
          name="bookTitle"
          required
          placeholder="Masukkan judul buku"
        />

        <label for="bookCategory">Kategori:</label>
        <input
          list="categoryDatalist"
          id="bookCategory"
          name="bookCategory"
          required
          placeholder="Pilih atau tulis kategori baru"
        />
        <datalist id="categoryDatalist"></datalist>

        <label for="bookStatus">Status:</label>
        <select id="bookStatus" name="bookStatus" required>
          <option value="Tersedia">Tersedia</option>
          <option value="Dipinjam">Dipinjam</option>
        </select>
        <menu>
          <button id="cancelBookForm" type="reset" class="secondary">Batal</button>
          <button type="submit" class="primary">Simpan</button>
        </menu>
      </form>
    </dialog>

    <section>
      <button onclick="window.location.href='logout.php'">Logout</button>
    </section>
  </main>

  <footer>

  </footer>

  <script>
    // Header image slideshow
    const headerImages = document.querySelectorAll(".header-image");
    let currentImage = 0;
    const totalImages = headerImages.length;
    const slideInterval = 2000; 
    function showNextImage() {
      headerImages[currentImage].classList.remove("active");
      currentImage = (currentImage + 1) % totalImages;
      headerImages[currentImage].classList.add("active");
    }
    setInterval(showNextImage, slideInterval);

    let books = [
      { id: 1, title: "Pemrograman JavaScript", category: "Pemrograman", status: "Tersedia" },
      { id: 2, title: "Belajar CSS Modern", category: "Desain Web", status: "Dipinjam" },
      { id: 3, title: "Basis Data untuk Pemula", category: "Database", status: "Tersedia" },
      { id: 4, title: "Algoritma dan Struktur Data", category: "Pemrograman", status: "Tersedia" }
    ];
    let loans = [];
    const categoryImages = {
      "Pemrograman": "https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=80&q=60",
      "Desain Web": "https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=80&q=60",
      "Database": "https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=80&q=60",
      "Default": "https://images.unsplash.com/photo-1506801310323-534be5e7bb72?auto=format&fit=crop&w=80&q=60"
    };

    const generateId = (array) => array.length ? Math.max(...array.map(item => item.id)) + 1 : 1;
    const categoryTable = document.getElementById("categoryTable");
    const booksTableBody = document.getElementById("booksTableBody");
    const bookSelect = document.getElementById("bookSelect");
    const loanForm = document.getElementById("loanForm");
    const loansTableBody = document.getElementById("loansTableBody");

    const bookDialog = document.getElementById("bookDialog");
    const bookForm = document.getElementById("bookForm");
    const bookFormTitle = document.getElementById("bookFormTitle");
    const bookTitleInput = document.getElementById("bookTitle");
    const bookCategoryInput = document.getElementById("bookCategory");
    const bookStatusSelect = document.getElementById("bookStatus");
    const btnAddBook = document.getElementById("btnAddBook");
    const cancelBookFormBtn = document.getElementById("cancelBookForm");

    let editingBookId = null;

    const borrowDateInput = document.getElementById("borrowDate");
    const todayStr = new Date().toISOString().split('T')[0];
    borrowDateInput.setAttribute('min', todayStr);

    function getCategories() {
      const cats = [...new Set(books.map(b => b.category))];
      return cats.sort();
    }
    function renderCategoryList() {
      const categories = getCategories();
      categoryTable.innerHTML = `
        <thead>
          <tr><th>Gambar</th><th>Kategori</th></tr>
        </thead>
        <tbody>
          ${categories.map(cat => {
            const imgSrc = categoryImages[cat] || categoryImages["Default"];
            return `<tr>
              <td><img src="${imgSrc}" alt="Ikon kategori ${cat}" loading="lazy" /></td>
              <td>${cat}</td>
            </tr>`;
          }).join('')}
        </tbody>
      `;
      const datalist = document.getElementById("categoryDatalist");
      datalist.innerHTML = "";
      categories.forEach(cat => {
        const option = document.createElement("option");
        option.value = cat;
        datalist.appendChild(option);
      });
    }
    function renderBooksTable() {
      booksTableBody.innerHTML = "";
      books.forEach(book => {
        const tr = document.createElement("tr");

        const tdTitle = document.createElement("td");
        tdTitle.textContent = book.title;

        const tdCategory = document.createElement("td");
        tdCategory.textContent = book.category;

        const tdStatus = document.createElement("td");
        tdStatus.textContent = book.status;
        tdStatus.className = book.status === "Tersedia" ? "status-available" : "status-unavailable";

        const tdActions = document.createElement("td");
        tdActions.className = "action-buttons";

        const editBtn = document.createElement("button");
        editBtn.textContent = "Edit";
        editBtn.className = "primary";
        editBtn.type = "button";
        editBtn.addEventListener("click", () => openEditBookDialog(book.id));

        const deleteBtn = document.createElement("button");
        deleteBtn.textContent = "Hapus";
        deleteBtn.className = "secondary";
        deleteBtn.type = "button";
        deleteBtn.addEventListener("click", () => deleteBook(book.id));

        tdActions.appendChild(editBtn);
        tdActions.appendChild(deleteBtn);

        tr.appendChild(tdTitle);
        tr.appendChild(tdCategory);
        tr.appendChild(tdStatus);
        tr.appendChild(tdActions);

        booksTableBody.appendChild(tr);
      });
      renderBookSelectOptions();
      renderCategoryList();
    }
    function renderBookSelectOptions() {
      bookSelect.innerHTML = '<option value="">-- Pilih buku --</option>';
      books.filter(b => b.status === "Tersedia").forEach(b => {
        const option = document.createElement("option");
        option.value = b.id;
        option.textContent = b.title;
        bookSelect.appendChild(option);
      });
    }
    function renderLoansTable() {
      loansTableBody.innerHTML = "";
      loans.forEach(loan => {
        const tr = document.createElement("tr");

        const tdBorrower = document.createElement("td");
        tdBorrower.textContent = loan.borrower;

        const tdTitle = document.createElement("td");
        const book = books.find(b => b.id === loan.bookId);
        tdTitle.textContent = book ? book.title : "(Buku tidak ditemukan)";

        const tdDate = document.createElement("td");
        tdDate.textContent = loan.date;

        const tdActions = document.createElement("td");
        const returnBtn = document.createElement("button");
        returnBtn.textContent = "Kembalikan";
        returnBtn.className = "contrast";
        returnBtn.type = "button";
        returnBtn.addEventListener("click", () => returnLoan(loan.id));
        tdActions.appendChild(returnBtn);

        tr.appendChild(tdBorrower);
        tr.appendChild(tdTitle);
        tr.appendChild(tdDate);
        tr.appendChild(tdActions);

        loansTableBody.appendChild(tr);
      });
    }
    function addBook(book) {
      book.id = generateId(books);
      books.push(book);
      renderBooksTable();
      alert("Buku berhasil ditambahkan.");
    }
    function updateBook(book) {
      const index = books.findIndex(b => b.id === book.id);
      if (index !== -1) {
        books[index] = book;
        renderBooksTable();
        alert("Buku berhasil diperbarui.");
      }
    }
    function deleteBook(bookId) {
      const isLoaned = loans.some(loan => loan.bookId === bookId);
      if (isLoaned) {
        alert("Buku sedang dipinjam dan tidak bisa dihapus.");
        return;
      }
      if (confirm("Apakah Anda yakin ingin menghapus buku ini?")) {
        books = books.filter(b => b.id !== bookId);
        renderBooksTable();
      }
    }
    function openAddBookDialog() {
      editingBookId = null;
      bookFormTitle.textContent = "Tambah Buku";
      bookTitleInput.value = "";
      bookCategoryInput.value = "";
      bookStatusSelect.value = "Tersedia";
      bookDialog.showModal();
    }
    function openEditBookDialog(bookId) {
      const book = books.find(b => b.id === bookId);
      if (!book) return alert("Buku tidak ditemukan.");
      editingBookId = bookId;
      bookFormTitle.textContent = "Edit Buku";
      bookTitleInput.value = book.title;
      bookCategoryInput.value = book.category;
      bookStatusSelect.value = book.status;
      bookDialog.showModal();
    }
    bookForm.addEventListener("submit", (evt) => {
      evt.preventDefault();
      const title = bookTitleInput.value.trim();
      const category = bookCategoryInput.value.trim();
      const status = bookStatusSelect.value;
      if (!title || !category || !status) {
        alert("Semua kolom harus diisi.");
        return;
      }
      if (editingBookId === null) {
        addBook({ title, category, status });
      } else {
        updateBook({ id: editingBookId, title, category, status });
      }
      bookDialog.close();
    });
    cancelBookFormBtn.addEventListener("click", () => {
      bookDialog.close();
    });
    btnAddBook.addEventListener("click", openAddBookDialog);
    loanForm.addEventListener("submit", (evt) => {
      evt.preventDefault();
      const borrowerName = loanForm.borrowerName.value.trim();
      const selectedBookId = parseInt(loanForm.bookSelect.value, 10);
      const borrowDate = loanForm.borrowDate.value;
      if (!borrowerName || !selectedBookId || !borrowDate) {
        alert("Semua kolom harus diisi.");
        return;
      }
      const book = books.find(b => b.id === selectedBookId);
      if (!book || book.status !== "Tersedia") {
        alert("Buku tidak tersedia untuk dipinjam.");
        renderBookSelectOptions();
        return;
      }
      const loanId = generateId(loans);
      loans.push({ id: loanId, borrower: borrowerName, bookId: selectedBookId, date: borrowDate });
      book.status = "Dipinjam";
      alert("Peminjaman berhasil diajukan.");
      loanForm.reset();
      loanForm.borrowDate.min = todayStr;
      renderBooksTable();
      renderLoansTable();
    });
    function returnLoan(loanId) {
      const loanIndex = loans.findIndex(l => l.id === loanId);
      if (loanIndex === -1) return alert("Data peminjaman tidak ditemukan.");
      const bookId = loans[loanIndex].bookId;
      loans.splice(loanIndex, 1);
      const book = books.find(b => b.id === bookId);
      if (book) {
        book.status = "Tersedia";
      }
      alert("Buku berhasil dikembalikan.");
      renderBooksTable();
      renderLoansTable();
      renderBookSelectOptions();
    }
    renderBooksTable();
    renderLoansTable();
    renderCategoryList(); 
  </script>
  <script>
  let index = 0;
  const images = document.querySelectorAll(".header-image");

  setInterval(() => {
    images[index].classList.remove("active");
    index = (index + 1) % images.length;
    images[index].classList.add("active");
  }, 5000); // Ganti setiap 5 detik
</script>
</body>
</html>