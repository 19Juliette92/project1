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
            const response = await axios.get('http://localhost/project1/src/api/PDO/home/api.php');
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

    // Filtrar los datos según el término de búsqueda
    const filteredData = data.filter((row) => {
        console.log(typeof row.num_doc, row.num_doc); // Esto te dirá el tipo de num_doc
        const numDoc = row.num_doc ? String(row.num_doc) : ''; 
        return numDoc.includes(searchTerm);
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
