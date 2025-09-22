// Ambil elemen cepat
const $ = id => document.getElementById(id);

// Ambil data sensor dari get.php
async function loadData() {
  try {
    let res = await fetch("./php/get.php");
    let d = await res.json();

    // Update suhu & kelembaban dari Antares
    $("temperature").innerText = d.temperature ?? "--";
    $("humidity").innerText = d.humidity ?? "--";
  } catch (e) {
    console.error("Gagal ambil data:", e);
  }
}

// Kirim perintah relay ke post.php
async function setRelay(state) {
  let relayValue = (state === "ON") ? 1 : 0;
  try {
    await fetch("./php/post.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ relay: relayValue })
    });

    // Status relay hanya ikut tombol yang diklik
    $("relayStatus").innerText = state;
  } catch (e) {
    console.error("Gagal set relay:", e);
  }
}

// Jalankan otomatis
window.onload = () => {
  loadData();
  setInterval(loadData, 5000); // auto refresh sensor tiap 5 detik
};
