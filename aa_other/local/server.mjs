import express from 'express'
import path from 'path'
import { fileURLToPath } from 'url';
import { dirname } from 'path';




const app = express();
const port = 59000;

const __filename = fileURLToPath(import.meta.url)
const __dirname = dirname(__filename)

app.use(express.static(path.join(__dirname, 'public')));


app.get('/', (req, res) => {
   res.sendFile(path.join(__dirname, 'public', 'index.html'));
});


app.listen(port, "0.0.0.0", () => {
   console.log(`Serveur lancé sur http://localhost:${port}`);
});
