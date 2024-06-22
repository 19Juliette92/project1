import React, { useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import "../../styles/AddPersona.css";

const AddEstacionamiento = () => {
  const [form, setForm] = useState({
    no_estacionamiento: "",
    id_titular: "",
    placa: "",
    id_inmueble: "",
    id_usuario: "",
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
        "http://localhost/projects/PDO/estacionamientos/api.php?apicall=createestacionamiento",
        form
      );
      console.log("Server response:", response); // Log the response from the server
      navigate("/Estacionamientos"); // Redirige a la lista de estacionamientos después de agregar
    } catch (error) {
      console.error("Error adding estacionamiento:", error);
      console.error(
        "Error response data:",
        error.response ? error.response.data : "No response data"
      ); // Log the response data
    }
  };

  return (
<div>
  <div className="contenedor-agregar">
    <h2>Adicionar Estacionamiento</h2>
    <form onSubmit={handleSubmit}>
      <div className="secciones-formulario">
        <div className="seccion">
          <label>Número estacionamento:</label>
          <input
          type="text"
            name="no_estacionamiento"
            onChange={handleChange}
            value={form.no_estacionamiento}
            className="input_agregar"
          />
          <br />
          <label>Propietario:</label>
          <input
            type="text"
            name="id_titular"
            onChange={handleChange}
            value={form.id_titular}
            className="input_agregar"
          />
          <br />
          <label>Placa:</label>
          <input
            type="text"
            name="placa"
            onChange={handleChange}
            value={form.placa}
            className="input_agregar"
          />
          <br />
          <label>Inmueble:</label>
          <input
            type="text"
            name="id_inmueble"
            onChange={handleChange}
            value={form.id_inmueble}
            className="input_agregar"
          />
          <br />
          <label>Usuario:</label>
          <input
            type="text"
            name="id_usuario"
            onChange={handleChange}
            value={form.id_usuario}
            className="input_agregar"
          />
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

export default AddEstacionamiento;
