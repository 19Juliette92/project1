import React, { useState, useEffect } from "react";
import axios from "axios";
import { useParams, useNavigate } from "react-router-dom";
import "../../styles/AddPersona.css";

const EditInmueble = () => {
  const { id_inmueble } = useParams();
  const navigate = useNavigate();
  const [form, setForm] = useState({
    bloque: "",
    apto: "",
    id_titular: "",
  });

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios.get(
          `http://localhost/projects/PDO/inmuebles/api.php?apicall=readinmueble&id_inmueble=${id_inmueble}`
        );
        if (response.data && !response.data.error && response.data.contenido) {
          // Extraer el objeto de inmueble del contenido
          const inmuebleId = Object.keys(response.data.contenido)[0]; // Obtiene la primera clave (id_inmueble)
          const inmueble = response.data.contenido[inmuebleId];

          // Actualizar el estado del formulario con los datos de la inmueble
          setForm({
            bloque: inmueble.bloque || "",
            apto: inmueble.apto || "",
            id_titular: inmueble.id_titular || "",
          });
        } else {
          console.error(
            "Error: No se encontró la inmueble para el ID proporcionado"
          );
        }
      } catch (error) {
        console.error("Error fetching inmueble data:", error);
      }
    };

    fetchData();
  }, [id_inmueble]);

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
        `http://localhost/projects/PDO/inmuebles/api.php?apicall=updateinmueble&id_inmueble=${id_inmueble}`,
        form
      );
      navigate("/inmuebles");
    } catch (error) {
      console.error("Error updating inmueble:", error);
    }
  };

  return (
    <div>
      <div className="contenedor-agregar">
        <h2>Editar Inmueble</h2>
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

export default EditInmueble;
