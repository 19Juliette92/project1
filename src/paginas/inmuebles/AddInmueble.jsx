import React, { useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import "../../styles/AddPersona.css";

const AddInmueble = () => {
  const [form, setForm] = useState({
    bloque: "",
    apto: "",
    id_titular: "",
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
        "http://localhost/project1/src/api/PDO/inmuebles/api.php?apicall=createinmueble",
        form
      );
      console.log("Server response:", response); // Log the response from the server
      navigate("/Inmuebles"); // Redirige a la lista de inmuebles después de agregar
    } catch (error) {
      console.error("Error adding inmueble:", error);
      console.error(
        "Error response data:",
        error.response ? error.response.data : "No response data"
      ); // Log the response data
    }
  };

  return (
<div>
  <div className="contenedor-agregar">
    <h2>Adicionar Inmueble</h2>
    <form onSubmit={handleSubmit}>
      <div className="secciones-formulario">
        <div className="seccion">
          <label>Bloque:</label>
          <input
            type="text"
            name="bloque"
            onChange={handleChange}
            value={form.bloque}
            className="input_agregar"
          />
          <br />
          <label>Apartamento:</label>
          <input
            type="text"
            name="apto"
            onChange={handleChange}
            value={form.apto}
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

export default AddInmueble;
