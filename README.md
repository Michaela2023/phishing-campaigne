Stránky běží v DOCKERU ! Musí být běžící v dockeru, protože PHP bez webserveru neběží ! - nefunguje zobrazení přes live-host


"PS C:\Users\mrezabkova\OneDrive - UP\Bureau\phishing 2026> docker compose up --build"






je třeba na ně přistupovat přes : http://localhost:8080/index.html

po přihlášení je username zapsáno do txt souboru ve složce "log"

zároveň je user přesměrován na vzdělávací stránku learn.html 


Řešení důvěryhodného certifikátu: 

Kam se certifikát typicky dává

Ne dovnitř tvého PHP kontejneru, ale před něj:

Nejjednodušší varianta

tvůj web běží dál v Dockeru na interním portu (třeba 8080)

před tím poběží reverse proxy (Nginx/Caddy/Traefik), která:

zařídí HTTPS

drží certifikát a automaticky ho obnovuje

přeposílá provoz do tvého kontejneru

To je standardní a nejmíň bolestivé.

Důležité k “VPN-only / interní přístup”

Když chceš, aby to nebylo veřejně dostupné, máš dvě cesty:

A) Server jen ve VLAN / přístup jen přes VPN

doména může být klidně veřejná

ale server nesmí být z internetu dosažitelný (firewall)

certifikát se pak často řeší přes DNS-01 (Let’s Encrypt přes DNS), protože HTTP ověření z internetu neprojde

B) Server veřejně dostupný, ale omezený přístup

firewall allowlist (jen vaše IP/VPN egress)

nebo Basic Auth / další brána před aplikací

certifikát je pak nejjednodušší (HTTP-01)

Co z toho plyne pro tebe

✅ Aplikaci (složky, Docker compose) máš hotovou a nezměníš ji
✅ Certifikát + https je “obal” na serveru
✅ Doména/DNS jen řekne “kam to směřuje”

Jediné, co bude potřeba rozhodnout, až budete nasazovat:

kde bude server (interní VLAN vs veřejná VPS)

jestli web bude z internetu dosažitelný nebo jen přes VPN

jestli chcete Let’s Encrypt DNS-01 (nejčistší pro VPN-only)


