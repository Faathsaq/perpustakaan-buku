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
    <title>Admin Page</title>
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
    <title>Dashboard Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&amp;display=swap" rel="stylesheet" />
    <style>
        /* CSS yang Anda berikan */
        body {
            background: linear-gradient(135deg, #f0f4f8, #d9e2ec);
            font-family: 'Poppins', "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #2e3a59;
            margin: 0;
            padding: 0;
        }

        main.container {
            margin-top: 6rem;
            padding: 2rem 1.5rem;
            max-width: 960px;
            margin-left: auto;
            margin-right: auto;
        }

        header {
            height: 320px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(46, 58, 89, 0.15);
            position: relative;
            background-color: #1f2937;
            cursor: pointer;
            margin-bottom: 3rem;
            
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        header.visible {
            opacity: 1;
            transform: translateY(0);
        }

        header:hover {
            transform: scale(1.04);
            box-shadow: 0 25px 50px rgba(46, 58, 89, 0.25);
        }

        .header-image {
            object-fit: cover;
            filter: brightness(0.55);
            opacity: 0;
            transition: opacity 1s ease-in-out;
            width: 100%;
            height: 100%;
        }

        .header-image.active {
            opacity: 1;
        }

        .overlay {
            position: absolute;
            bottom: 0;
            width: 100%;
            background: linear-gradient(to top, rgba(31, 41, 55, 0.85), transparent);
            color: #f9fafb;
            padding: 2.5rem 2rem 3rem;
            border-radius: 0 0 20px 20px;
            text-align: center;
            user-select: none;
        }

        .overlay h1 {
            font-size: 3.5rem;
            margin-bottom: 0.6rem;
            font-weight: 700;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.4);
            letter-spacing: 1.5px;
            line-height: 1.1;
        }

        .overlay p {
            font-size: 1.3rem;
            font-weight: 500;
            opacity: 0.9;
            max-width: 650px;
            margin: 0 auto;
        }

        section {
            background: #fff;
            padding: 2.5rem 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(46, 58, 89, 0.05);
            margin-bottom: 3rem;
            transition: box-shadow 0.35s ease, transform 0.35s ease;
            
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        section.visible {
            opacity: 1;
            transform: translateY(0);
        }

        section:hover {
            box-shadow: 0 15px 45px rgba(46, 58, 89, 0.12);
            transform: translateY(-6px);
        }

        table {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px;
        }

        table th, table td {
            padding: 1rem 1.2rem;
            text-align: left;
            border-bottom: none;
            color: #475569;
            font-weight: 600;
        }

        table tr {
            background: #f8fafc;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.04);
            transition: background-color 0.3s ease;
        }

        table tr:hover {
            background-color: #e0e7ff;
        }

        .status-available::before {
            content: "🟢 ";
        }

        .status-unavailable::before {
            content: "🔴 ";
        }

        .action-buttons button {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.6rem 1.4rem;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.95rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.07);
            transition: background-color 0.35s ease, box-shadow 0.35s ease;
            user-select: none;
        }

        .action-buttons button.primary {
            background-color: #4f46e5;
            color: white;
        }

        .action-buttons button.primary:hover {
            background-color: #4338ca;
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.45);
        }

        .action-buttons button.secondary {
            background-color: #ef4444;
            color: white;
        }

        .action-buttons button.secondary:hover {
            background-color: #b91c1c;
            box-shadow: 0 10px 25px rgba(239, 68, 68, 0.45);
        }

        .action-buttons button.contrast {
            background-color: #10b981;
            color: white;
        }

        .action-buttons button.contrast:hover {
            background-color: #047857;
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.45);
        }

        #loanForm {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.3rem;
        }

        #loanForm label {
            grid-column: span 2;
            font-weight: 700;
            color: #334155;
        }

        #loanForm input,
        #loanForm select {
            width: 100%;
            padding: 0.65rem 1rem;
            border: 2px solid #cbd5e1;
            border-radius: 10px;
            font-size: 1rem;
            color: #1e293b;
            transition: border-color 0.4s ease, box-shadow 0.4s ease;
            box-shadow: inset 0 1px 2px rgb(0 0 0 / 0.06);
        }

        #loanForm input:focus,
        #loanForm select:focus {
            border-color: #4f46e5;
            outline: none;
            box-shadow: 0 0 8px 0 #4f46e5aa;
        }

        #loanForm button {
            grid-column: span 2;
            font-size: 1.1rem;
            padding: 0.9rem;
            background-color: #4f46e5;
            color: white;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 700;
            letter-spacing: 0.05em;
            transition: background-color 0.35s ease, box-shadow 0.35s ease;
        }

        #loanForm button:hover {
            background-color: #4338ca;
            box-shadow: 0 12px 30px rgba(79, 70, 229, 0.5);
        }

        footer {
            text-align: center;
            padding: 3rem 0 2rem;
            color: #64748b;
            font-size: 0.95rem;
            margin-top: 4rem;
            border-top: 1px solid #cbd5e1;
            user-select: none;
        }

        nav.container-fluid {
            background-color: #fff;
            box-shadow: 0 6px 15px rgba(46, 58, 89, 0.08);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 999;
            border-radius: 0 0 24px 24px;
        }

        nav ul {
            display: flex;
            justify-content: center;
            gap: 1.8rem;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        nav ul li a {
            text-decoration: none;
            color: #334155;
            font-weight: 600;
            padding: 0.6rem 1.3rem;
            border-radius: 14px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        nav ul li a:hover,
        nav ul li a:focus {
            background-color: #e0e7ff;
            color: #4f46e5;
            outline: none;
        }

        /* Card for summary data */
        .dashboard-cards {
            display: flex;
            justify-content: space-between;
            gap: 1.5rem;
            margin-bottom: 3rem;
            flex-wrap: wrap;
        }

        .card {
            flex: 1 1 200px;
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(46, 58, 89, 0.05);
            text-align: center;
            cursor: default;
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 15px 45px rgba(46, 58, 89, 0.12);
            transform: translateY(-5px);
        }

        .card h3 {
            font-size: 1.8rem;
            margin-bottom: 0.25rem;
            color: #4f46e5;
        }

        .card p {
            font-size: 1.1rem;
            font-weight: 600;
            color: #64748b;
            margin: 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            #loanForm {
                grid-template-columns: 1fr;
            }

            .overlay h1 {
                font-size: 2.75rem;
            }

            .overlay p {
                font-size: 1.1rem;
            }

            nav ul {
                flex-direction: column;
                gap: 1rem;
            }

            .dashboard-cards {
                flex-direction: column;
            }
        }

        /* Container for charts in laporan */
        .chart-container {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 1rem;
        }
        .chart-box {
            background: #f8fafc;
            border-radius: 16px;
            padding: 1rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.04);
            flex: 1 1 280px;
            text-align: center;
        }
        canvas {
            max-width: 100%;
            height: auto;
        }
        .chart-title {
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>

<nav class="container-fluid">
    <ul>
        <li><a href="#">Dashboard</a></li>
        <li><a href="#pengguna">Pengguna</a></li>
        <li><a href="#buku">Buku</a></li>
        <li><a href="#peminjaman">Peminjaman</a></li>
        <li><a href="#laporan">Laporan</a></li>
    </ul>
</nav>

<main class="container">

    <header id="header">
        <img src="header-image.jpg" alt="Header Image" class="header-image active" />
        <div class="overlay">
            <!-- <h1>Selamat Datang di Dashboard Admin</h1> -->
            <h1>Welcome, <span><?= $_SESSION['name']; ?></span><br>di Dashboard Admin</h1>
            <p>Kelola semua data dan informasi dengan mudah.</p>
        </div>
    </header>

    <section class="dashboard-cards" aria-label="Ringkasan Data Utama" id="dashboardCards">
        <div class="card" aria-live="polite">
            <h3 id="countUsers">0</h3>
            <p>Pengguna Aktif</p>
        </div>
        <div class="card" aria-live="polite">
            <h3 id="countBooks">0</h3>
            <p>Buku Tersedia</p>
        </div>
        <div class="card" aria-live="polite">
            <h3 id="countLoans">0</h3>
            <p>Peminjaman Aktif</p>
        </div>
    </section>

    <section id="pengguna" aria-label="Daftar Pengguna" class="section">
        <h2>Pengguna</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>John Doe</td>
                    <td>john@example.com</td>
                    <td class="status-available">Aktif</td>
                </tr>
                <tr>
                    <td>Jane Smith</td>
                    <td>jane@example.com</td>
                    <td class="status-unavailable">Tidak Aktif</td>
                </tr>
                <tr>
                    <td>Alfian Ardiansyah</td>
                    <td>alfian@example.com</td>
                    <td class="status-available">Aktif</td>
                </tr>
            </tbody>
        </table>
    </section>

    <section id="buku" aria-label="Daftar Buku" class="section">
        <h2>Buku</h2>
        <div class="action-buttons" style="margin-bottom: 1.5rem;">
            <button class="primary">Tambah Buku</button>
            <button class="secondary">Hapus Buku</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Kategori</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Belajar JavaScript</td>
                    <td>Agus Santoso</td>
                    <td>Pemrograman</td>
                    <td class="status-available">Tersedia</td>
                </tr>
                <tr>
                    <td>Desain UI Modern</td>
                    <td>Sari Putri</td>
                    <td>Desain</td>
                    <td class="status-unavailable">Dipinjam</td>
                </tr>
                <tr>
                    <td>Sejarah Indonesia</td>
                    <td>Budi Wijaya</td>
                    <td>Sejarah</td>
                    <td class="status-available">Tersedia</td>
                </tr>
            </tbody>
        </table>
    </section>

    <section id="peminjaman" aria-label="Data Peminjaman Buku" class="section">
        <h2>Peminjaman</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama Pengguna</th>
                    <th>Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>John Doe</td>
                    <td>Desain UI Modern</td>
                    <td>2023-03-21</td>
                    <td>2023-04-04</td>
                    <td class="status-available">Aktif</td>
                </tr>
                <tr>
                    <td>Jane Smith</td>
                    <td>Belajar JavaScript</td>
                    <td>2023-04-10</td>
                    <td>2023-04-17</td>
                    <td class="status-unavailable">Terlewat</td>
                </tr>
                <tr>
                    <td>Alfian Ardiansyah</td>
                    <td>Sejarah Indonesia</td>
                    <td>2023-04-15</td>
                    <td>2023-04-29</td>
                    <td class="status-available">Aktif</td>
                </tr>
            </tbody>
        </table>
    </section>

    <section id="laporan" aria-label="Laporan Statistik" class="section">
        <h2>Laporan</h2>
        <ul style="list-style:none; padding-left:0; font-weight:600; color:#334155;">
            <li>Jumlah Pengguna Aktif: <strong>120</strong></li>
            <li>Jumlah Buku Tersedia: <strong>89</strong></li>
            <li>Jumlah Peminjaman Aktif: <strong>41</strong></li>
        </ul>

        <div class="chart-container" role="region" aria-label="Diagram laporan statistik">

            <div class="chart-box">
                <div class="chart-title">Pengembalian Tepat Waktu</div>
                <canvas id="pieChart" width="280" height="280" aria-label="Diagram lingkaran pengembalian tepat waktu" role="img"></canvas>
            </div>

            <div class="chart-box">
                <div class="chart-title">Buku Populer Bulan Ini</div>
                <canvas id="barChart" width="280" height="280" aria-label="Diagram batang buku populer bulan ini" role="img"></canvas>
            </div>

        </div>
    </section>

    <div class="action-buttons">
        <button class="secondary" onclick="window.location.href='logout.php'">Logout</button>
    </div>
</main>

<footer>
    &copy; 2023 Dashboard Admin. Semua hak dilindungi.
</footer>

<script>
    // Data for charts and counts
    const pieData = {
        timely: 85,
        late: 15
    };

    const popularBooks = [
        { title: "Desain UI Modern", count: 14 },
        { title: "Belajar JavaScript", count: 9 },
        { title: "Sejarah Indonesia", count: 5 },
        { title: "Pemrograman Python", count: 3 }
    ];

    const counts = {
        users: 120,
        books: 89,
        loans: 41
    };

    // Count up animation function
    function countUp(element, target, duration = 2000) {
        let start = 0;
        const stepTime = Math.abs(Math.floor(duration / target));
        return new Promise((resolve) => {
            let timer = setInterval(() => {
                start += 1;
                element.textContent = start;
                if (start >= target) {
                    clearInterval(timer);
                    element.textContent = target;
                    resolve();
                }
            }, stepTime);
        });
    }

    // Draw Pie Chart for Pengembalian Tepat Waktu with animated count
    function drawPieChart() {
        const canvas = document.getElementById('pieChart');
        if (!canvas.getContext) return;
        const ctx = canvas.getContext('2d');
        const centerX = canvas.width / 2;
        const centerY = canvas.height / 2;
        const radius = Math.min(centerX, centerY) - 20;

        let currentPercent = 0;
        const targetPercent = pieData.timely;
        const animationDuration = 2000; // ms
        const frameRate = 60;
        const totalFrames = Math.round(frameRate * (animationDuration / 1000));
        let frame = 0;

        function animate() {
            frame++;
            currentPercent = Math.min(targetPercent, (frame / totalFrames) * targetPercent);

            // Clear canvas
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            const timelyAngle = (currentPercent / 100) * 2 * Math.PI;
            const lateAngle = ((100 - currentPercent) / 100) * 2 * Math.PI;

            // Colors
            const timelyColor = '#10b981'; // green
            const lateColor = '#ef4444';   // red

            // Draw timely arc
            ctx.beginPath();
            ctx.moveTo(centerX, centerY);
            ctx.arc(centerX, centerY, radius, 0, timelyAngle, false);
            ctx.fillStyle = timelyColor;
            ctx.fill();

            // Draw late arc
            ctx.beginPath();
            ctx.moveTo(centerX, centerY);
            ctx.arc(centerX, centerY, radius, timelyAngle, timelyAngle + lateAngle, false);
            ctx.fillStyle = lateColor;
            ctx.fill();

            // Draw circle border
            ctx.beginPath();
            ctx.arc(centerX, centerY, radius, 0, 2 * Math.PI);
            ctx.lineWidth = 3;
            ctx.strokeStyle = '#4f46e5';
            ctx.stroke();

            // Text - timely percentage (animated)
            ctx.fillStyle = '#334155';
            ctx.font = "bold 32px Poppins, sans-serif";
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText(Math.floor(currentPercent) + "%", centerX, centerY);

            ctx.font = "14px Poppins, sans-serif";
            ctx.fillText("Tepat Waktu", centerX, centerY + 30);

            // Legend
            ctx.fillStyle = timelyColor;
            ctx.fillRect(20, canvas.height - 40, 16, 16);
            ctx.fillStyle = '#334155';
            ctx.font = "14px Poppins, sans-serif";
            ctx.fillText("Tepat Waktu", 50, canvas.height - 28);

            ctx.fillStyle = lateColor;
            ctx.fillRect(140, canvas.height - 40, 16, 16);
            ctx.fillStyle = '#334155';
            ctx.fillText("Terlambat", 170, canvas.height - 28);

            if (frame < totalFrames) {
                requestAnimationFrame(animate);
            }
        }

        animate();
    }

    // Draw Bar Chart for Buku Populer with animated count labels
    function drawBarChart() {
        const canvas = document.getElementById('barChart');
        if (!canvas.getContext) return;
        const ctx = canvas.getContext('2d');

        const padding = 40;
        const barWidth = 40;
        const gap = 25;
        const maxCount = Math.max(...popularBooks.map(b => b.count));
        const chartHeight = canvas.height - 2 * padding;
        const baseY = canvas.height - padding;

        let frame = 0;
        const animationDuration = 2000;
        const frameRate = 60;
        const totalFrames = Math.round(frameRate * (animationDuration / 1000));

        function animate() {
            frame++;
            const progress = Math.min(1, frame / totalFrames);

            // Clear canvas
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Axis line
            ctx.strokeStyle = '#475569';
            ctx.lineWidth = 1;
            ctx.beginPath();
            ctx.moveTo(padding, baseY);
            ctx.lineTo(canvas.width - padding, baseY);
            ctx.stroke();

            ctx.font = "14px Poppins, sans-serif";
            ctx.fillStyle = '#334155';
            ctx.textAlign = "center";

            popularBooks.forEach((book, i) => {
                const x = padding + i * (barWidth + gap);
                const targetBarHeight = (book.count / maxCount) * chartHeight;
                const barHeight = targetBarHeight * progress;
                const countVal = Math.floor(book.count * progress);

                // Bar
                ctx.fillStyle = '#4f46e5';
                ctx.fillRect(x, baseY - barHeight, barWidth, barHeight);

                // Title (rotated - vertical)
                ctx.save();
                ctx.translate(x + barWidth / 2, baseY + 5);
                ctx.rotate(-Math.PI / 4);
                ctx.fillStyle = '#334155';
                ctx.fillText(book.title, 0, 0);
                ctx.restore();

                // Count label on top of bar (animated)
                ctx.fillStyle = '#475569';
                ctx.fillText(countVal, x + barWidth / 2, baseY - barHeight - 10);
            });

            if (frame < totalFrames) {
                requestAnimationFrame(animate);
            }
        }

        animate();
    }

    // Intersection Observer to trigger animations on visibility
    document.addEventListener("DOMContentLoaded", () => {
        // Animate header
        const header = document.getElementById('header');
        const sections = document.querySelectorAll('section');
        const countUsers = document.getElementById('countUsers');
        const countBooks = document.getElementById('countBooks');
        const countLoans = document.getElementById('countLoans');
        const pieChartCanvas = document.getElementById('pieChart');
        const barChartCanvas = document.getElementById('barChart');

        // Observer options
        const options = {
            threshold: 0.3
        };

        // Animate header
        const headerObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if(entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, options);
        headerObserver.observe(header);

        // Animate sections
        const sectionObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if(entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, options);
        sections.forEach(section => sectionObserver.observe(section));

        // Animate count ups for cards
        const countObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if(entry.isIntersecting) {
                    if(entry.target.id === 'countUsers') countUp(entry.target, counts.users);
                    if(entry.target.id === 'countBooks') countUp(entry.target, counts.books);
                    if(entry.target.id === 'countLoans') countUp(entry.target, counts.loans);
                    observer.unobserve(entry.target);
                }
            });
        }, options);
        [countUsers, countBooks, countLoans].forEach(el => countObserver.observe(el));

        // Animate charts when laporan section is visible
        const laporanSection = document.getElementById('laporan');
        const chartObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if(entry.isIntersecting) {
                    drawPieChart();
                    drawBarChart();
                    observer.unobserve(entry.target);
                }
            });
        }, options);
        chartObserver.observe(laporanSection);
    });

</script>
</body>
</html>