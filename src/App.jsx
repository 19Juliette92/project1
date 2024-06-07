import React from 'react';
import './App.css';
import Header from './components/Header'; // Importa el componente Header
import Menu_nav from './components/Menu_nav';

function App() {
  return (
    <div className="app-container">
      <Header /> {/* Usa el componente Header */}
      <Menu_nav /> {/* Usa el componente Menu_nav */}
      {/* Otro contenido de la aplicación */}
    </div>
  );
}

export default App;



// import React, { useEffect, useState } from "react";

// import "./App.css";

// function App() {
//   const [personas, setPersonas] = useState([]);

//   useEffect(() => {
//     fetchPersonas();
//   }, []);

//   const fetchPersonas = async () => {
//     try {
//       const response = await fetch(
//         "http://localhost/projects/PDO/personas/api.php?apicall=readpersona"
//       );

//       const text = await response.text();

//       console.log("Response text:", text);

//       const data = JSON.parse(text);

//       console.log("Parsed data:", data);

//       if (!data.error && data.contenido) {
//         // Aseguramos que contenido existe

//         setPersonas(data.contenido);
//       }
//     } catch (error) {
//       console.error("Error fetching personas:", error);
//     }
//   };

//   return (
//     <div className="App">
//       <h1>Personas</h1>

//       <div className="dashboard">
//         <div className="sidebar">
//           <h2>Menú</h2>

//           <ul>
//             <li>
//               <a href="#">Inicio</a>
//             </li>

//             <li>
//               <a href="#">Personas</a>
//             </li>

//             <li>
//               <a href="#">Configuración</a>
//             </li>
//           </ul>
//         </div>

//         <div className="main-content">
//           <div className="table-section">
//             <div className="card">
//               <h3>Total Personas</h3>

//               <p>{personas.length}</p>
//             </div>

//             <div>
//               <div className="filters">
//                 <h3>Filtros</h3>

//                 <form>
//                   <input type="text" placeholder="Buscar por nombre..." />

//                   <input type="text" placeholder="Buscar por documento..." />

//                   <button type="button">Buscar</button>
//                 </form>
//               </div>

//               <div className="table-container">
//                 <table>
//                   <thead>
//                     <tr>
//                       <th>ID</th>

//                       <th>Tipo Persona</th>

//                       <th>Tipo Documento</th>

//                       <th>Número Documento</th>

//                       <th>Nombres</th>

//                       <th>Apellidos</th>

//                       <th>Género</th>

//                       <th>Email</th>

//                       <th>Teléfono</th>

//                       <th>Fecha Creación</th>

//                       <th>Fecha Actualización</th>

//                       <th>Acciones</th>
//                     </tr>
//                   </thead>

//                   <tbody>
//                     {personas.length > 0 ? (
//                       personas.map((persona) => (
//                         <tr key={persona.id_persona}>
//                           <td>{persona.id_persona}</td>

//                           <td>{persona.tipo_persona}</td>

//                           <td>{persona.tip_doc}</td>

//                           <td>{persona.num_doc}</td>

//                           <td>{persona.nombres}</td>

//                           <td>{persona.apellidos}</td>

//                           <td>{persona.genero}</td>

//                           <td>{persona.email}</td>

//                           <td>{persona.telefono}</td>

//                           <td>{persona.fecha_creacion}</td>

//                           <td>{persona.fecha_actualizacion}</td>
//                           <td>
//                             <button onClick={() => handleEdit(persona)}>Actualizar</button>
//                             <button onClick={() => handleDelete(persona.id_persona)}>Eliminar</button>
//                           </td>
//                         </tr>
//                       ))
//                     ) : (
//                       <tr>
//                         <td colSpan="11">No hay datos disponibles</td>
//                       </tr>
//                     )}
//                   </tbody>
//                 </table>
//               </div>
//             </div>
//           </div>
//         </div>
//       </div>
//     </div>
//   );
// }

// export default App;
