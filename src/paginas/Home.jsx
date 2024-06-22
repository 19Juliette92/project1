// import React, { useEffect, useState } from "react";
// import axios from "axios";
// import "../styles/Personas.css";

// const Home = () => {
//   const [data, setData] = useState([]);

//   useEffect(() => {
//     fetchData();
//   }, []);

//   const fetchData = async () => {
//     try {
//       const response = await axios.get(
//         "http://localhost/projects/PDO/home/api.php"
//       );
//       if (response.data.error) {
//         console.error(response.data.message);
//       } else {
//         setData(response.data.contenido);
//       }
//     } catch (error) {
//       console.error("Error fetching data", error);
//     }
//   };

//   return (
//     <div className="contenedor-principal">
//       <div className="contenedor-tabla">
//         <div className="contenedor-busqueda">
//           <input
//             type="text"
//             placeholder="Buscar por número de documento"
//             value={searchTerm}
//             onChange={handleSearchChange}
//           />
//         </div>
//         <table>
//           <thead>
//             <tr>
//               <th>Nombres</th>
//               <th>Apellidos</th>
//               <th>Documento</th>
//               <th>Bloque</th>
//               <th>Apartamento</th>
//               <th>Placa del vehículo</th>
//               <th>Estacionamiento</th>
//             </tr>
//           </thead>
//           <tbody>
//             {data.map((row) => (
//               <tr key={row.id_persona}>
//                 <td>{row.nombres}</td>
//                 <td>{row.apellidos}</td>
//                 <td>{row.num_doc}</td>
//                 <td>{row.bloque}</td>
//                 <td>{row.apto}</td>
//                 <td>{row.placa}</td>
//                 <td>{row.no_estacionamiento}</td>
//               </tr>
//             ))}
//           </tbody>
//         </table>
//       </div>
//     </div>
//   );
// };

// export default Home;

import React, { useEffect, useState } from 'react';
import axios from 'axios';
import '../styles/Personas.css';
import '@fortawesome/fontawesome-free/css/all.min.css';

const Home = () => {
    const [data, setData] = useState([]);
    const [searchTerm, setSearchTerm] = useState(''); // Definición correcta de searchTerm

    useEffect(() => {
        fetchData();
    }, []);

    const fetchData = async () => {
        try {
            const response = await axios.get('http://localhost/projects/PDO/home/api.php');
            if (response.data.error) {
                console.error(response.data.message);
            } else {
                setData(response.data.contenido);
            }
        } catch (error) {
            console.error('Error fetching data', error);
        }
    };

    // Función para manejar cambios en la caja de búsqueda
    const handleSearchChange = (event) => {
        setSearchTerm(event.target.value);
    };

    // Función para filtrar los datos basados en el término de búsqueda
    const filteredData = data.filter((row) => {
        return row.num_doc.includes(searchTerm);
    });

    return (
        <div className="contenedor-principal">
            <div className="contenedor-busqueda">
                <br />
                <input
                    type="text"
                    placeholder="Buscar por número de documento"
                    value={searchTerm}
                    onChange={handleSearchChange}
                    className="busqueda-input"
                />
                <i className="fas fa-search busqueda-icono"></i>
            </div>
            <div className="contenedor-tabla">
                <table>
                    <thead>
                        <tr>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Documento</th>
                            <th>Bloque</th>
                            <th>Apartamento</th>
                            <th>Placa del vehículo</th>
                            <th>Estacionamiento</th>
                        </tr>
                    </thead>
                    <tbody>
                        {filteredData.map((row) => (
                            <tr key={row.id_persona}>
                                <td>{row.nombres}</td>
                                <td>{row.apellidos}</td>
                                <td>{row.num_doc}</td>
                                <td>{row.bloque}</td>
                                <td>{row.apto}</td>
                                <td>{row.placa}</td>
                                <td>{row.no_estacionamiento}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </div>
    );
};

export default Home;
