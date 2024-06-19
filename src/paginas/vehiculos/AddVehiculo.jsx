import React, { useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import "../../styles/AddPersona.css";

const AddVehiculo = () => {
  const [form, setForm] = useState({
    placa: "",  
    id_conductor: "",
    marca: "",
    modelo: "",
    color: "",
    tipo_vehiculo: "",
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

    if (!form.placa) {
      alert("El campo Placa no puede estar vacío");
      return;
    }

    try {
      const response = await axios.post(
        "http://localhost/projects/PDO/vehiculos/api.php?apicall=createvehiculo",
        form
      );
      console.log("Server response:", response); // Log the response from the server
      navigate("/Vehiculos"); // Redirige a la lista de vehiculos después de agregar
    } catch (error) {
      console.error("Error adding vehiculo:", error);
      console.error(
        "Error response data:",
        error.response ? error.response.data : "No response data"
      ); // Log the response data
    }
  };

  return (
    <div>
      <div className="contenedor-agregar">
        <h2>Adicionar Vehiculo</h2>
        <form onSubmit={handleSubmit}>
          <div className="secciones-formulario">
            <div className="seccion">
              <label>Placa:</label>
              <input
                type="text"
                name="placa"
                onChange={handleChange}
                value={form.placa}
                className="input_agregar"
              />
              <br />
              <label>Propietario:</label>
              <input
                type="text"
                name="id_conductor"
                onChange={handleChange}
                value={form.id_conductor}
                className="input_agregar"
              />
              <br />
              <label>Marca:</label>
              <input
                type="text"
                name="marca"
                onChange={handleChange}
                value={form.marca}
                className="input_agregar"
              />
              <br />
              <label>Modelo:</label>
              <input
                type="text"
                name="modelo"
                onChange={handleChange}
                value={form.modelo}
                className="input_agregar"
              />
              <br />
              <label>Color:</label>
              <input
                type="text"
                name="color"
                onChange={handleChange}
                value={form.color}
                className="input_agregar"
              />
              <br />
              <label>Tipo de vehiculo:</label>
              <select
                name="tipo_vehiculo"
                onChange={handleChange}
                value={form.tipo_vehiculo}
                className="input_agregar"
              >
                <option value="">Seleccionar...</option>
                <option value="TV001">Moto</option>
                <option value="TV002">Vehículo</option>
                <option value="TV003">Camioneta</option>
              </select>
              <br />
              <br />
              <div className="acciones-formulario">
                <button type="submit" className="button_agregar">
                  Adicionar
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  );
};

export default AddVehiculo;
