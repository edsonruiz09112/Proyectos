export default async function handler(req, res) {
  // Solo permitimos peticiones POST
  if (req.method !== 'POST') {
    return res.status(405).json({ message: 'Method not allowed' });
  }

  try {
    // 1. Recibimos el texto que enviaste desde el Frontend
    const { query } = req.body;

    if (!query) {
      return res.status(400).json({ message: 'Falta el query' });
    }

    // 2. Construimos manualmente el paquete "Multipart" que pide Python.
    // Hacemos esto manual para no necesitar instalar librerías extra.
    const boundary = '----WebKitFormBoundary7MA4YWxkTrZu0gW';
    const bodyPayload = [
      `--${boundary}`,
      `Content-Disposition: form-data; name="search_content"`,
      '',
      query,
      `--${boundary}--`,
      ''
    ].join('\r\n');

    // 3. Enviamos la petición al servidor de Python desde aquí (Node.js)
    // Al ser servidor-a-servidor, NO HAY CORS.
    const pythonRes = await fetch('https://pysearch.onrender.com/search/', {
      method: 'POST',
      headers: {
        'Content-Type': `multipart/form-data; boundary=${boundary}`,
      },
      body: bodyPayload,
    });

    // 4. Verificamos si Python respondió bien
    if (!pythonRes.ok) {
      const errorText = await pythonRes.text();
      throw new Error(`Error del Backend Python (${pythonRes.status}): ${errorText}`);
    }

    // 5. Devolvemos los datos limpios a tu Frontend
    const data = await pythonRes.json();
    res.status(200).json(data);

  } catch (error) {
    console.error("Error en el Proxy:", error);
    res.status(500).json({ message: error.message });
  }
}