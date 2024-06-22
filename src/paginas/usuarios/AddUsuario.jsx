import React, { useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import "../../styles/AddPersona.css";

const AddUsuario = () => {
  const [form, setForm] = useState({
    nombre_usuario: "",
    contrasena: "",
    email: "",
    fecha_creacion: "",
  });

  const navigate = useNavigate();

  const handleChange = (e) => {
    setForm({
      ...form,
      [e.target.name]: e.target.value,
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    console.log("Submitting form:", form); // Log the form data before submission
    try {
      const response = await axios.post(
        "http://localhost/projects/PDO/usuarios/api.php?apicall=createusuario",
        form
      );
      console.log("Server response:", response); // Log the response from the server
      navigate("/usuarios"); // Redirige a la lista de usuarios después de agregar
    } catch (error) {
      console.error("Error adding usuario:", error);
      console.error(
        "Error response data:",
        error.response ? error.response.data : "No response data"
      ); // Log the response data
    }
  };

  return (
<div>
  <div className="contenedor-agregar">
    <h2>Adicionar Usuario</h2>
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
            <button type="submit" className="button_agregar">Adicionar</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

  );
};

export default AddUsuario;
