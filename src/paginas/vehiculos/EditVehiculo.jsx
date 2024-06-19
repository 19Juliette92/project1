import React, { useState, useEffect } from "react";
import axios from "axios";
import { useParams, useNavigate } from "react-router-dom";
import "../../styles/AddPersona.css";

const EditVehiculo = () => {
  const { placa } = useParams();
  const navigate = useNavigate();
  const [form, setForm] = useState({
    placa: "",
    id_conductor: "",
    marca: "",
    modelo: "",
    color: "",
    tipo_vehiculo: "",
  });

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios.get(
          `http://localhost/projects/PDO/vehiculos/api.php?apicall=readvehiculo&placa=${placa}`
        );
        if (response.data && !response.data.error && response.data.contenido) {
          // Extraer el objeto de vehiculo del contenido
          const vehiculoId = Object.keys(response.data.contenido)[0]; // Obtiene la primera clave (placa)
          const vehiculo = response.data.contenido[vehiculoId];

          // Actualizar el estado del formulario con los datos de la vehiculo
          setForm({
            placa: vehiculo.placa || "",
            id_conductor: vehiculo.id_conductor || "",
            marca: vehiculo.marca || "",
            modelo: vehiculo.modelo || "",
            color: vehiculo.color || "",
            tipo_vehiculo: vehiculo.tipo_vehiculo || "",
            email: vehiculo.email || "",
            telefono: vehiculo.telefono || "",
          });
        } else {
          console.error(
            "Error: No se encontró la vehiculo para el ID proporcionado"
          );
        }
      } catch (error) {
        console.error("Error fetching vehiculo data:", error);
      }
    };

    fetchData();
  }, [placa]);

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
        `http://localhost/projects/PDO/vehiculos/api.php?apicall=updatevehiculo&placa=${placa}`,
        form
      );
      navigate("/Vehiculos");
    } catch (error) {
      console.error("Error updating vehiculo:", error);
    }
  };

  return (
    <div>
      <div className="contenedor-agregar">
        <h2>Editar Vehiculo</h2>
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

export default EditVehiculo;
