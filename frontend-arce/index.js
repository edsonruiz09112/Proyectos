import { useState } from 'react';

export default function Home() {
  const [query, setQuery] = useState('');
  const [results, setResults] = useState([]);
  const [loading, setLoading] = useState(false);
  const [searched, setSearched] = useState(false);
  const [errorMsg, setErrorMsg] = useState('');

  const handleSearch = async (e) => {
    e.preventDefault();
    if (!query.trim()) return;

    setLoading(true);
    setSearched(true);
    setResults([]);
    setErrorMsg('');

    console.log("--- BÚSQUEDA ---");

    try {
      const res = await fetch('/api/search', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: query }),
      });

      const data = await res.json();
      
      if (Array.isArray(data) && data.length > 0 && data[0].error) {
        throw new Error(data[0].error);
      }

      let finalResults = [];
      if (Array.isArray(data)) {
        finalResults = data;
      } else if (data && Array.isArray(data.results)) {
        finalResults = data.results;
      } else if (data && typeof data === 'object') {
        const possibleKey = Object.keys(data).find(key => Array.isArray(data[key]));
        if (possibleKey) finalResults = data[possibleKey];
      }

      setResults(finalResults);

    } catch (error) {
      if (error.message.includes("inicializandose") || error.message.includes("503")) {
        setErrorMsg("⏳ El servidor se está despertando. Espera unos segundos...");
      } else {
        setErrorMsg(`Algo salió mal: ${error.message}`);
      }
    } finally {
      setLoading(false);
    }
  };

  // ESTILOS EN LÍNEA (Garantizan que se vea bien sin Tailwind)
  const styles = {
    page: {
      minHeight: '100vh',
      backgroundColor: '#202124', // Fondo Oscuro Google
      color: '#e8eaed',
      fontFamily: 'Arial, sans-serif',
      display: 'flex',
      flexDirection: 'column',
      alignItems: 'center',
      margin: 0,
      padding: 0,
      overflowX: 'hidden'
    },
    container: {
      width: '100%',
      maxWidth: '650px',
      padding: '20px',
      display: 'flex',
      flexDirection: 'column',
      alignItems: 'center',
      // Si no se ha buscado, baja el contenido para centrarlo en la pantalla
      marginTop: searched ? '20px' : '30vh', 
      transition: 'margin-top 0.4s ease-in-out'
    },
    title: {
      fontSize: searched ? '2rem' : '4.5rem',
      fontWeight: 'bold',
      marginBottom: '30px',
      color: '#ffffff',
      cursor: 'pointer',
      userSelect: 'none',
      letterSpacing: '-2px'
    },
    form: {
      width: '100%',
      position: 'relative'
    },
    input: {
      width: '100%',
      padding: '14px 25px',
      borderRadius: '30px',
      border: '1px solid #5f6368',
      backgroundColor: '#303134',
      color: 'white',
      fontSize: '18px',
      outline: 'none',
      // Sombra suave
      boxShadow: '0 1px 6px rgba(0,0,0,0.2)'
    },
    loadingBar: {
      width: '100%',
      height: '3px',
      backgroundColor: '#303134',
      marginTop: '15px',
      borderRadius: '2px',
      overflow: 'hidden',
      position: 'relative'
    },
    loadingProgress: {
      height: '100%',
      backgroundColor: '#8ab4f8',
      width: '50%',
      animation: 'move 1s infinite linear' // Nota: La animación necesita keyframes en CSS global, pero esto servirá visualmente
    },
    resultsContainer: {
      width: '100%',
      maxWidth: '800px',
      padding: '0 20px',
      paddingBottom: '50px'
    },
    resultItem: {
      marginBottom: '30px',
      maxWidth: '650px'
    },
    urlText: {
      color: '#bdc1c6',
      fontSize: '14px',
      marginBottom: '5px',
      display: 'block'
    },
    resultTitle: {
      color: '#8ab4f8',
      fontSize: '20px',
      textDecoration: 'none',
      display: 'block',
      marginBottom: '3px',
      cursor: 'pointer'
    },
    resultDesc: {
      color: '#bdc1c6',
      fontSize: '14px',
      lineHeight: '1.58'
    }
  };

  return (
    <div style={styles.page}>
      
      {/* Contenedor Central */}
      <div style={styles.container}>
        
        {/* TÍTULO LSHForest */}
        <h1 
          style={styles.title}
          onClick={() => {if(searched) {setSearched(false); setQuery(''); setResults([]);}}}
        >
          <span style={{ fontSize: '1.15em' }}>LSH</span>Forest
        </h1>

        {/* BARRA DE BÚSQUEDA (Sin iconos, limpia) */}
        <form onSubmit={handleSearch} style={styles.form}>
          <input
            type="text"
            style={styles.input}
            value={query}
            onChange={(e) => setQuery(e.target.value)}
            placeholder="Buscar..."
          />
        </form>

        {/* Barra de carga simulada */}
        {loading && (
          <div style={styles.loadingBar}>
             <div style={{...styles.loadingProgress, width: '100%'}}></div> 
             <p style={{textAlign: 'center', fontSize: '12px', color: '#9aa0a6', marginTop: '5px'}}>Buscando...</p>
          </div>
        )}

        {/* Mensajes de Error */}
        {errorMsg && (
          <div style={{marginTop: '20px', color: '#f28b82', backgroundColor: 'rgba(242, 139, 130, 0.1)', padding: '10px', borderRadius: '5px'}}>
            {errorMsg}
          </div>
        )}

      </div>

      {/* RESULTADOS */}
      {searched && results.length > 0 && (
        <div style={styles.resultsContainer}>
          <p style={{color: '#9aa0a6', fontSize: '14px', marginBottom: '20px', paddingLeft: '5px'}}>
            Cerca de {results.length} resultados
          </p>
          
          {results.map((movie, index) => {
            if (!movie || (!movie.title && !movie.titulo && !movie.url)) return null;

            return (
              <div key={index} style={styles.resultItem}>
                
                {/* URL */}
                <span style={styles.urlText}>
                  {movie.url || "lsh-forest.com"}
                </span>

                {/* Título */}
                <a 
                  href={movie.url || movie.link || '#'} 
                  target="_blank" 
                  rel="noopener noreferrer"
                  style={styles.resultTitle}
                  onMouseOver={(e) => e.target.style.textDecoration = 'underline'}
                  onMouseOut={(e) => e.target.style.textDecoration = 'none'}
                >
                  {movie.title || movie.titulo || "Sin título"}
                </a>

                {/* Descripción */}
                <p style={styles.resultDesc}>
                  {movie.description || movie.descripcion || "No hay descripción disponible."}
                </p>

                {/* Datos extra: SIMILITUD SOLAMENTE */}
                <div style={{fontSize: '12px', color: '#9aa0a6', marginTop: '5px'}}>
                   Similitud: {((movie.similarity || movie.score || 0) * 100).toFixed(0)}%
                </div>
              </div>
            );
          })}
        </div>
      )}
    </div>
  );
}