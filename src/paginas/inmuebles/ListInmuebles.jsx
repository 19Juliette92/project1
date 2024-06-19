import React, { useEffect, useState } from "react";
import axios from "axios";
import { Link, useNavigate } from "react-router-dom";
import "../../styles/Personas.css"; // Asegúrate de tener los estilos CSS para este componente

const ListInmuebles = () => {
  const [inmuebles, setInmuebles] = useState([]);
  const navigate = useNavigate();

  useEffect(() => {
    axios
      .get("http://localhost/projects/PDO/inmuebles/api.php?apicall=readinmueble")
      .then((response) => {
        setInmuebles(response.data.contenido);
      })
      .catch((error) => {
        console.error("Error fetching inmuebles:", error);
      });
  }, []);

  const handleDelete = (id_inmueble) => {
    if (window.confirm("¿Está seguro de eliminar el registro?")) {
      axios
        .delete(
          `http://localhost/projects/PDO/inmuebles/api.php?apicall=deleteinmueble&id_inmueble=${id_inmueble}`
        )
        .then((response) => {
          // Actualizar la lista de inmuebles después de eliminar
          setInmuebles(
            inmuebles.filter((inmueble) => inmueble.id_inmueble !== id_inmueble)
          );
        })
        .catch((error) => {
          console.error("Error deleting inmueble:", error);
        });
    }
  };

  return (
    <div className="contenedor-principal">
      <div className="enlaces-crud">
        <Link to="/Inmuebles/AddInmueble">Adicionar</Link>
      </div>
      <div className="contenedor-tabla">
        <table>
          <thead>
            <tr>
              <th>Bloque</th>
              <th>Apartamento</th>
              <th>Propietario</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            {inmuebles.map((inmueble) => (
              <tr key={inmueble.id_inmueble}>
                <td>{inmueble.bloque}</td>
                <td>{inmueble.apto}</td>
                <td>{`${inmueble.nombres} ${inmueble.apellidos}`}</td>
                <td>
                  <button
                    onClick={() =>
                      navigate(`/inmuebles/edit/${inmueble.id_inmueble}`)
                    }
                    className="editar"
                  >
                    Editar
                  </button>
                  <button
                    onClick={() => handleDelete(inmueble.id_inmueble)}
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

export default ListInmuebles;
