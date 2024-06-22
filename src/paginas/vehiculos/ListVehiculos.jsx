// src/pages/vehiculos/Listvehiculos.jsx
import React, { useEffect, useState } from "react";
import axios from "axios";
import { Link, useNavigate } from "react-router-dom";
import "../../styles/Personas.css"; // Asegúrate de tener los estilos CSS para este componente

const ListVehiculos = () => {
  const [vehiculos, setVehiculos] = useState([]);
  const navigate = useNavigate();

  useEffect(() => {
    axios
      .get(
        "http://localhost/projects/PDO/vehiculos/api.php?apicall=readvehiculo"
      )
      .then((response) => {
        setVehiculos(response.data.contenido);
      })
      .catch((error) => {
        console.error("Error fetching vehiculos:", error);
      });
  }, []);

  const handleDelete = (placa) => {
    if (window.confirm("¿Está seguro de eliminar el registro?")) {
      axios
        .delete(
          `http://localhost/projects/PDO/vehiculos/api.php?apicall=deletevehiculo&placa=${placa}`
        )
        .then((response) => {
          // Actualizar la lista de vehiculos después de eliminar
          setVehiculos(
            vehiculos.filter((vehiculo) => vehiculo.placa !== placa)
          );
        })
        .catch((error) => {
          console.error("Error deleting vehiculo:", error);
        });
    }
  };

  return (
    <div className="contenedor-principal">
      <div className="enlaces-crud">
        <Link to="/Vehiculos/Addvehiculo">Adicionar</Link>
      </div>
      <div className="contenedor-tabla">
        <table>
          <thead>
            <tr>
              <th>Placa</th>
              <th>Propietario</th>
              <th>Marca</th>
              <th>Modelo</th>
              <th>Color</th>
              <th>Tipo de vehiculo</th>
              <th>Fecha registro</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>
            {vehiculos.map((vehiculo) => (
              <tr key={vehiculo.placa}>
                <td>{vehiculo.placa}</td>
                <td>{`${vehiculo.nombres} ${vehiculo.apellidos}`}</td>
                <td>{vehiculo.marca}</td>
                <td>{vehiculo.modelo}</td>
                <td>{vehiculo.color}</td>
                <td>{vehiculo.nombre_tipo}</td>
                <td>{vehiculo.fecha_registro}</td>
                <td>
                  <button
                    onClick={() =>
                      navigate(`/vehiculos/edit/${vehiculo.placa}`)
                    }
                    className="editar"
                  >
                    Editar
                  </button>
                  <button
                    onClick={() => handleDelete(vehiculo.placa)}
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

export default ListVehiculos;
