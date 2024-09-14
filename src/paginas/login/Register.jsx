// src/components/Register.jsx
import React, { useState } from "react";
import { Link } from "react-router-dom";
import { useNavigate } from "react-router-dom";
import axios from "axios";
import "../../styles/registro_inicio.css"; // Ajusta la ruta según tu estructura
import logo from "../../assets/img/Intelligate_logo.jpg";

const Register = () => {
  const [formData, setFormData] = useState({
    nombre_usuario: "",
    contrasena: "",
    email: "",
    estado: "",
  });
  const [errorMsg, setErrorMsg] = useState("");
  const [successMsg, setSuccessMsg] = useState("");
  const navigate = useNavigate();

  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value,
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setErrorMsg("");
    setSuccessMsg("");

    try {
      const response = await axios.post(
        "http://localhost/project1/src/api/PDO/usuarios/api.php?apicall=createusuario",
        formData
      );
      if (!response.data.error) {
        setSuccessMsg("Registro Exitoso! Ahora puede ingresar.");
        navigate("/login");
      } else {
        setErrorMsg(response.data.message || "Error en el registro.");
      }
    } catch (error) {
      setErrorMsg("Error al comunicarse con el servidor.");
    }
  };

  return (
    <div className="registro-container">
      <div>
        <div className="caja-registro">
          <div>
            <img className="logo" src={logo} alt="Logo de IntelliGate" />
          </div>
          <div className="registro-titulo">Regístrate</div>
          <form onSubmit={handleSubmit}>
            <input
              type="text"
              name="nombre_usuario"
              placeholder="Usuario"
              value={formData.nombre_usuario}
              onChange={handleChange}
              className="caja"
              required
            />
            <br />
            <br />
            <input
              type="password"
              name="contrasena"
              placeholder="Contraseña"
              value={formData.contrasena}
              onChange={handleChange}
              className="caja"
              required
            />
            <br />
            <br />
            <input
              type="email"
              name="email"
              placeholder="Correo Electrónico"
              value={formData.email}
              onChange={handleChange}
              className="caja"
              required
            />
            <br />
            <br />
            <input
              type="text"
              name="estado"
              placeholder="Estado"
              value={formData.estado}
              onChange={handleChange}
              className="caja"
              required
            />
            <br />
            <br />

            <span className="registro-enlace">
              <button type="submit" className="btn-registro">
                Registro
              </button>
            </span>
          </form>
          {errorMsg && <div className="mensaje-error">{errorMsg}</div>}
          {successMsg && <div className="mensaje-exito">{successMsg}</div>}
        </div>
      </div>
    </div>
  );
};

export default Register;
