import React, { useState, useEffect } from "react";
import axios from "axios";
import { useParams, useNavigate } from "react-router-dom";
import "../../styles/AddPersona.css";

const EsitUsuario = () => {
  const { id_usuario } = useParams();
  const navigate = useNavigate();
  const [form, setForm] = useState({
    nombre_usuario: "",
    contrasena: "",
    email: "",
    estado: "",
  });

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios.get(
          `http://localhost/projects/PDO/usuarios/api.php?apicall=readusuario&id_usuario=${id_usuario}`
        );
        if (response.data && !response.data.error && response.data.contenido) {
          // Extraer el objeto de usuario del contenido
          const usuarioId = Object.keys(response.data.contenido)[0]; // Obtiene la primera clave (id_usuario)
          const usuario = response.data.contenido[usuarioId];

          // Actualizar el estado del formulario con los datos de la usuario
          setForm({
            nombre_usuario: usuario.nombre_usuario || "",
            contrasena: usuario.contrasena || "",
            email: usuario.email || "",
            estado: usuario.estado || "",
          });
        } else {
          console.error(
            "Error: No se encontró la usuario para el ID proporcionado"
          );
        }
      } catch (error) {
        console.error("Error fetching usuario data:", error);
      }
    };

    fetchData();
  }, [id_usuario]);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setForm({
      ...form,
      [name]: value,
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await axios.put(
        `http://localhost/projects/PDO/usuarios/api.php?apicall=updateusuario&id_usuario=${id_usuario}`,
        form
      );
      navigate("/Usuarios");
    } catch (error) {
      console.error("Error updating usuario:", error);
    }
  };

  return (
    <div>
      <div className="contenedor-agregar">
        <h2>Editar Usuario</h2>
        <form onSubmit={handleSubmit}>
          <div className="secciones-formulario">
            <div className="seccion">
            <label>Nombre usuario:</label>
          <input
            type="text"
            name="nombre_usuario"
            onChange={handleChange}
            value={form.nombre_usuario}
            className="input_agregar"
          />
          <br />
          <label>Contraseña:</label>
          <input
            type="text"
            name="contrasena"
            onChange={handleChange}
            value={form.contrasena}
            className="input_agregar"
          />
          <br />
          <label>Email:</label>
          <input
            type="text"
            name="email"
            onChange={handleChange}
            value={form.email}
            className="input_agregar"
          />
          <br />
          <label>Estado:</label>
          <select
            name="estado"
            onChange={handleChange}
            value={form.estado}
            className="input_agregar"
          >
            <option value="">Seleccionar...</option>
            <option value="activo">Activo</option>
            <option value="inactivo">Inactivo</option>
          </select>
              <br />
              <div className="acciones-formulario">
                <button type="submit" className="button_agregar">
                  Actualizar
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  );
};

export default EsitUsuario;
