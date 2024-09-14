// src/pages/estacionamientos/ListEstacionamientos.jsx
import React, { useEffect, useState } from "react";
import axios from "axios";
import { Link, useNavigate } from "react-router-dom";
import "../../styles/Personas.css"; // Asegúrate de tener los estilos CSS para este componente

const ListEstacionamientos = () => {
  const [estacionamientos, setEstacionamientos] = useState([]);
  const navigate = useNavigate();

  useEffect(() => {
    axios
      .get("http://localhost/projects/PDO/estacionamientos/api.php?apicall=readestacionamiento")
      .then((response) => {
        console.log("Response data:", response.data);
        if (response.data && response.data.contenido) {
          setEstacionamientos(response.data.contenido);
        } else {
          console.error("Unexpected response format:", response.data);
        }
      })
      .catch((error) => {
        console.error("Error fetching estacionamientos:", error);
      });
  }, []);

  const handleDelete = (id_estacionamiento) => {
    if (window.confirm("¿Está seguro de eliminar el registro?")) {
      axios
        .delete(`http://localhost/projects/PDO/estacionamientos/api.php?apicall=deleteestacionamiento&id_estacionamiento=${id_estacionamiento}`)
        .then((response) => {
          console.log("Estacionamiento deleted:", id_estacionamiento);
          // Actualizar la lista de estacionamientos después de eliminar
          setEstacionamientos(estacionamientos.filter(
            (estacionamiento) => estacionamiento.id_estacionamiento !== id_estacionamiento
          ));
        })
        .catch((error) => {
          console.error("Error deleting estacionamiento:", error);
        });
    }
  };

  return (
    <div className="contenedor-principal">
      <br />
        <Link to="/Estacionamientos/AddEstacionamiento" className="enlaces-crud">Adicionar</Link>      
      <div className="contenedor-tabla">
        <br />
        <table>
          <thead>
            <tr>
              <th>Nombre estacionamiento</th>
              <th>Propietario</th>
              <th>Placa</th>
              <th>Inmueble</th>
              <th>Usuario</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>
            {estacionamientos.map((estacionamiento) => (
              <tr key={estacionamiento.id_estacionamiento}>
                <td>{estacionamiento.no_estacionamiento}</td>
                <td>{`${estacionamiento.nombres} ${estacionamiento.apellidos}`}</td>
                <td>{estacionamiento.placa}</td>
                <td>{`${estacionamiento.bloque} ${estacionamiento.apto}`}</td>
                <td>{estacionamiento.nombre_usuario}</td>
                <td>
                  <button
                    onClick={() => navigate(`/Estacionamientos/edit/${estacionamiento.id_estacionamiento}`)}
                    className="editar"
                  >
                    Editar
                  </button>
                  <button
                    onClick={() => handleDelete(estacionamiento.id_estacionamiento)}
                    className="eliminar"
                  >
                    Eliminar
                  </button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
};

export default ListEstacionamientos;


