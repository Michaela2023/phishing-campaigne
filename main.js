function log_login() {
  const email = document.getElementById("email").value.trim();

  if (!email) {
    alert("Vyplň e-mail.");
    return;
  }

  const body = new URLSearchParams();
  body.set("email", email);

  fetch("login.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body
  })
    .then(async (res) => {
      // Zkusíme přečíst JSON, ale když nevyjde, pořád redirectneme
      let data = null;
      try {
        data = await res.json();
      } catch (e) {
        // login.php možná nevrací JSON – nevadí
      }

      // pokud server spadl (500 apod.), tak neredirectujeme a ukážeme chybu
      if (!res.ok) {
        const msg = (data && (data.error || data.message)) ? (data.error || data.message) : "Chyba serveru při logování.";
        throw new Error(msg);
      }

      // ✅ logování proběhlo → redirect
      window.location.href = (data && data.redirect) ? data.redirect : "learn.html";
    })
    .catch((e) => {
      console.error(e);
      alert(e.message || "Chyba komunikace se serverem.");
    });
}
