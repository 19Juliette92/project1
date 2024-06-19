import React, { useState, useEffect } from "react";
import axios from "axios";
import { useParams, useNavigate } from "react-router-dom";
import "../../styles/AddPersona.css";

const EditPersona = () => {
  const { id_persona } = useParams();
  const navigate = useNavigate();
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

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios.get(
          `http://localhost/projects/PDO/personas/api.php?apicall=readpersona&id_persona=${id_persona}`
        );
        if (response.data && !response.data.error && response.data.contenido) {
          // Extraer el objeto de persona del contenido
          const personaId = Object.keys(response.data.contenido)[0]; // Obtiene la primera clave (id_persona)
          const persona = response.data.contenido[personaId];

          // Actualizar el estado del formulario con los datos de la persona
          setForm({
            tipo_persona: persona.tipo_persona || "",
            tip_doc: persona.tip_doc || "",
            num_doc: persona.num_doc || "",
            nombres: persona.nombres || "",
            apellidos: persona.apellidos || "",
            genero: persona.genero || "",
            email: persona.email || "",
            telefono: persona.telefono || "",
          });
        } else {
          console.error(
            "Error: No se encontró la persona para el ID proporcionado"
          );
        }
      } catch (error) {
        console.error("Error fetching persona data:", error);
      }
    };

    fetchData();
  }, [id_persona]);

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
        `http://localhost/projects/PDO/personas/api.php?apicall=updatepersona&id_persona=${id_persona}`,
        form
      );
      navigate("/Personas");
    } catch (error) {
      console.error("Error updating persona:", error);
    }
  };

  return (
    <div>
      <div className="contenedor-agregar">
        <h2>Editar Persona</h2>
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

export default EditPersona;
