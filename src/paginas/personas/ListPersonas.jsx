// src/pages/Personas/ListPersonas.jsx
import React, { useEffect, useState } from "react";
import axios from "axios";
import { Link, useNavigate } from "react-router-dom";
import "../../styles/Personas.css"; // Asegúrate de tener los estilos CSS para este componente

const ListPersonas = () => {
  const [personas, setPersonas] = useState([]);
  const navigate = useNavigate();

  useEffect(() => {
    axios
      .get("http://localhost/projects/PDO/personas/api.php?apicall=readpersona")
      .then((response) => {
        setPersonas(response.data.contenido);
      })
      .catch((error) => {
        console.error("Error fetching personas:", error);
      });
  }, []);

  const handleDelete = (id_persona) => {
    if (window.confirm("¿Está seguro de eliminar el registro?")) {
      axios
        .delete(
          `http://localhost/projects/PDO/personas/api.php?apicall=deletepersona&id_persona=${id_persona}`
        )
        .then((response) => {
          // Actualizar la lista de personas después de eliminar
          setPersonas(
            personas.filter((persona) => persona.id_persona !== id_persona)
          );
        })
        .catch((error) => {
          console.error("Error deleting persona:", error);
        });
    }
  };

  return (
    <div className="contenedor-principal">
      <div className="enlaces-crud">
        <Link to="/Personas/AddPersona">Adicionar</Link>
      </div>
      <div className="contenedor-tabla">
        <table>
          <thead>
            <tr>
              <th>Tipo persona</th>
              <th>Tipo documento</th>
              <th>Número de identificación</th>
              <th>Nombres</th>
              <th>Apellidos</th>
              <th>Género</th>
              <th>Email</th>
              <th>Teléfono</th>
              <th>Fecha creación</th>
              <th>Fecha actualización</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>
            {personas.map((persona) => (
              <tr key={persona.id_persona}>
                <td>{persona.nombre_tipo}</td>
                <td>{persona.tip_doc}</td>
                <td>{persona.num_doc}</td>
                <td>{persona.nombres}</td>
                <td>{persona.apellidos}</td>
                <td>{persona.genero}</td>
                <td>{persona.email}</td>
                <td>{persona.telefono}</td>
                <td>{persona.fecha_creacion}</td>
                <td>{persona.fecha_actualizacion}</td>
                <td>
                  <td>
                    <button
                      onClick={() =>
                        navigate(`/personas/edit/${persona.id_persona}`)
                      }
                      className="editar"
                    >
                      Editar
                    </button>
                    <button
                      onClick={() => handleDelete(persona.id_persona)}
                      className="eliminar"
                    >
                      Eliminar
                    </button>
                  </td>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
};

export default ListPersonas;
