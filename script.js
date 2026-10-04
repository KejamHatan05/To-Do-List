// ============================================================
//   INTERAKSI TO-DO LIST (fetch ke backend PHP)
// ============================================================

const formTambah = document.getElementById("formTambah");
const inputTugas = document.getElementById("inputTugas");
const daftarTugas = document.getElementById("daftarTugas");
const ringkasan = document.getElementById("ringkasan");
const filterGrup = document.getElementById("filterGrup");

let filterAktif = "semua";

// ---------- Hitung ulang ringkasan "x/y selesai" ----------
function perbaruiRingkasan() {
    const semuaItem = daftarTugas.querySelectorAll(".tugas-item");
    const jumlahSelesai = daftarTugas.querySelectorAll(".tugas-item.selesai").length;
    ringkasan.textContent = `${jumlahSelesai}/${semuaItem.length} selesai`;
}

// ---------- Terapkan filter (Semua / Aktif / Selesai) ----------
function terapkanFilter() {
    const semuaItem = daftarTugas.querySelectorAll(".tugas-item");
    semuaItem.forEach((item) => {
        const sudahSelesai = item.classList.contains("selesai");
        let tampilkan = true;

        if (filterAktif === "aktif") tampilkan = !sudahSelesai;
        if (filterAktif === "selesai") tampilkan = sudahSelesai;

        item.classList.toggle("tersembunyi", !tampilkan);
    });
}

// ---------- Buat elemen <li> baru untuk satu tugas ----------
function buatElemenTugas(id, teks, selesai) {
    const li = document.createElement("li");
    li.className = "tugas-item" + (selesai ? " selesai" : "");
    li.dataset.id = id;
    li.dataset.selesai = selesai ? "1" : "0";

    li.innerHTML = `
        <span class="tugas-centang"></span>
        <span class="tugas-teks"></span>
        <button class="tugas-hapus" title="Hapus">✕</button>
    `;
    li.querySelector(".tugas-teks").textContent = teks; // textContent supaya aman dari XSS

    return li;
}

// ---------- Tambah tugas baru ----------
formTambah.addEventListener("submit", async (event) => {
    event.preventDefault();

    const teks = inputTugas.value.trim();
    if (!teks) return;

    try {
        const formData = new FormData();
        formData.append("teks", teks);

        const response = await fetch("tambah.php", { method: "POST", body: formData });
        const hasil = await response.json();

        if (hasil.status !== "ok") {
            alert(hasil.pesan || "Gagal menambah tugas.");
            return;
        }

        // Hapus pesan "belum ada tugas" kalau masih ada
        const pesanKosong = document.getElementById("pesanKosong");
        if (pesanKosong) pesanKosong.remove();

        const elemenBaru = buatElemenTugas(hasil.tugas.id, hasil.tugas.teks, hasil.tugas.selesai);
        daftarTugas.prepend(elemenBaru);

        inputTugas.value = "";
        perbaruiRingkasan();
        terapkanFilter();
    } catch (error) {
        alert("Terjadi kesalahan koneksi ke server.");
    }
});

// ---------- Toggle selesai & Hapus (event delegation) ----------
daftarTugas.addEventListener("click", async (event) => {
    const item = event.target.closest(".tugas-item");
    if (!item) return;

    const id = item.dataset.id;

    // Klik lingkaran centang atau teks -> toggle selesai
    if (event.target.classList.contains("tugas-centang") || event.target.classList.contains("tugas-teks")) {
        try {
            const formData = new FormData();
            formData.append("id", id);

            const response = await fetch("toggle.php", { method: "POST", body: formData });
            const hasil = await response.json();

            if (hasil.status === "ok") {
                item.classList.toggle("selesai", hasil.selesai === 1);
                item.dataset.selesai = hasil.selesai;
                perbaruiRingkasan();
                terapkanFilter();
            }
        } catch (error) {
            alert("Gagal memperbarui status tugas.");
        }
    }

    // Klik tombol hapus
    if (event.target.classList.contains("tugas-hapus")) {
        try {
            const formData = new FormData();
            formData.append("id", id);

            const response = await fetch("hapus.php", { method: "POST", body: formData });
            const hasil = await response.json();

            if (hasil.status === "ok") {
                item.remove();
                perbaruiRingkasan();

                if (daftarTugas.children.length === 0) {
                    const li = document.createElement("li");
                    li.className = "kosong";
                    li.id = "pesanKosong";
                    li.textContent = "Belum ada tugas. Tambahkan satu di atas!";
                    daftarTugas.appendChild(li);
                }
            }
        } catch (error) {
            alert("Gagal menghapus tugas.");
        }
    }
});

// ---------- Filter Semua / Aktif / Selesai ----------
filterGrup.addEventListener("click", (event) => {
    if (!event.target.classList.contains("filter__btn")) return;

    filterGrup.querySelectorAll(".filter__btn").forEach((btn) => btn.classList.remove("aktif"));
    event.target.classList.add("aktif");

    filterAktif = event.target.dataset.filter;
    terapkanFilter();
});