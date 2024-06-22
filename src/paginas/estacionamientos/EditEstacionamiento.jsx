import React, { useState, useEffect } from "react";
import axios from "axios";
import { useParams, useNavigate } from "react-router-dom";
import "../../styles/AddPersona.css";

const EditEstacionamiento = () => {
  const { id_estacionamiento } = useParams();
  const navigate = useNavigate();
  const [form, setForm] = useState({
    no_estacionamiento: "",
    id_titular: "",
    placa: "",
    id_inmueble: "",
    id_usuario: "",
  });

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios.get(
          `http://localhost/projects/PDO/estacionamientos/api.php?apicall=readestacionamiento&id_estacionamiento=${id_estacionamiento}`
        );
        if (response.data && !response.data.error && response.data.contenido) {
          // Extraer el objeto de estacionamiento del contenido
          const estacionamientoId = Object.keys(response.data.contenido)[0]; // Obtiene la primera clave (id_estacionamiento)
          const estacionamiento = response.data.contenido[estacionamientoId];

          // Actualizar el estado del formulario con los datos de la estacionamiento
          setForm({
            no_estacionamiento: estacionamiento.no_estacionamiento || "",
            id_titular: estacionamiento.id_titular || "",
            placa: estacionamiento.placa || "",
            id_inmueble: estacionamiento.id_inmueble || "",
            id_usuario: estacionamiento.id_usuario || "",
          });
        } else {
          console.error(
            "Error: No se encontró la estacionamiento para el ID proporcionado"
          );
        }
      } catch (error) {
        console.error("Error fetching estacionamiento data:", error);
      }
    };

    fetchData();
  }, [id_estacionamiento]);

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
        `http://localhost/projects/PDO/estacionamientos/api.php?apicall=updateestacionamiento&id_estacionamiento=${id_estacionamiento}`,
        form
      );
      navigate("/Estacionamientos");
    } catch (error) {
      console.error("Error updating estacionamiento:", error);
    }
  };

  return (
    <div>
      <div className="contenedor-agregar">
        <h2>Editar Estacionamiento</h2>
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

export default EditEstacionamiento;
