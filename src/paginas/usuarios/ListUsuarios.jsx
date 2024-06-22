// src/pages/usuarios/ListUsuarios.jsx
import React, { useEffect, useState } from "react";
import axios from "axios";
import { Link, useNavigate } from "react-router-dom";
import "../../styles/Personas.css"; // Asegúrate de tener los estilos CSS para este componente

const ListUsuarios = () => {
  const [usuarios, setUsuarios] = useState([]);
  const navigate = useNavigate();

  useEffect(() => {
    axios
      .get("http://localhost/projects/PDO/usuarios/api.php?apicall=readusuario")
      .then((response) => {
        setUsuarios(response.data.contenido);
      })
      .catch((error) => {
        console.error("Error fetching usuarios:", error);
      });
  }, []);

  const handleDelete = (id_usuario) => {
    if (window.confirm("¿Está seguro de eliminar el registro?")) {
      axios
        .delete(
          `http://localhost/projects/PDO/usuarios/api.php?apicall=deleteusuario&id_usuario=${id_usuario}`
        )
        .then((response) => {
          // Actualizar la lista de usuarios después de eliminar
          setUsuarios(
            usuarios.filter((usuario) => usuario.id_usuario !== id_usuario)
          );
        })
        .catch((error) => {
          console.error("Error deleting usuario:", error);
        });
    }
  };

  return (
    <div className="contenedor-principal">
      <div className="enlaces-crud">
        <Link to="/Usuarios/AddUsuario">Adicionar</Link>
      </div>
      <div className="contenedor-tabla">
        <table>
          <thead>
            <tr>
              <th>Nombre usuario</th>
              <th>Contraseña</th>
              <th>Email</th>
              <th>Fecha creación</th>
              <th>Estado</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>
            {usuarios.map((usuario) => (
              <tr key={usuario.id_usuario}>
                <td>{usuario.nombre_usuario}</td>
                <td>{usuario.contrasena}</td>
                <td>{usuario.email}</td>
                <td>{usuario.fecha_creacion}</td>
                <td>{usuario.estado}</td>
                <td>
                  <button
                    onClick={() =>
                      navigate(`/usuarios/edit/${usuario.id_usuario}`)
                    }
                    className="editar"
                  >
                    Editar
                  </button>
                  <button
                    onClick={() => handleDelete(usuario.id_usuario)}
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

export default ListUsuarios;
