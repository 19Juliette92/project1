import React, { useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import "../../styles/AddPersona.css";

const AddPersona = () => {
  const [form, setForm] = useState({
    tipo_persona: "",
    tip_doc: "",
    num_doc: "",
    nombres: "",
    apellidos: "",
    genero: "",
    email: "",
    telefono: "",
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
        "http://localhost/projects/PDO/personas/api.php?apicall=createpersona",
        form
      );
      console.log("Server response:", response); // Log the response from the server
      navigate("/Personas"); // Redirige a la lista de personas después de agregar
    } catch (error) {
      console.error("Error adding persona:", error);
      console.error(
        "Error response data:",
        error.response ? error.response.data : "No response data"
      ); // Log the response data
    }
  };

  return (
<div>
  <div className="contenedor-agregar">
    <h2>Adicionar Persona</h2>
    <form onSubmit={handleSubmit}>
      <div className="secciones-formulario">
        <div className="seccion">
          <label>Tipo de persona:</label>
          <select
            name="tipo_persona"
            onChange={handleChange}
            value={form.tipo_persona}
            className="input_agregar"
          >
            <option value="">Seleccionar...</option>
            <option value="TP001">Propietario</option>
            <option value="TP002">Arrendatario</option>
            <option value="TP003">Visitante</option>
          </select>
          <br />
          <label>Tipo de documento:</label>
          <select
            name="tip_doc"
            onChange={handleChange}
            value={form.tip_doc}
            className="input_agregar"
          >
            <option value="">Seleccionar...</option>
            <option value="CC">CC</option>
            <option value="TI">TI</option>
            <option value="PP">PP</option>
            <option value="CE">CE</option>
            <option value="NIT">NIT</option>
            <option value="Otro">Otro</option>
          </select>
          <br />
          <label>Número de identificación:</label>
          <input
            type="text"
            name="num_doc"
            onChange={handleChange}
            value={form.num_doc}
            className="input_agregar"
          />
          <br />
          <label>Nombres:</label>
          <input
            type="text"
            name="nombres"
            onChange={handleChange}
            value={form.nombres}
            className="input_agregar"
          />
          <br />
          <label>Apellidos:</label>
          <input
            type="text"
            name="apellidos"
            onChange={handleChange}
            value={form.apellidos}
            className="input_agregar"
          />
          <br />
          <label>Género:</label>
          <select
            name="genero"
            onChange={handleChange}
            value={form.genero}
            className="input_agregar"
          >
            <option value="">Seleccionar...</option>
            <option value="Femenino">Femenino</option>
            <option value="Masculino">Masculino</option>
            <option value="Otros">Otros</option>
          </select>
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
          <label>Teléfono:</label>
          <input
            type="text"
            name="telefono"
            onChange={handleChange}
            value={form.telefono}
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

export default AddPersona;
