import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import "../../styles/estilosInicioSesion.css";
import logo from "../../assets/img/Intelligate_logo.jpg";

const Login = () => {
  const [nombreUsuario, setNombreUsuario] = useState("");
  const [contrasena, setContrasena] = useState("");
  const [errMsg, setErrMsg] = useState("");
  const navigate = useNavigate();

  const handleLogin = async (e) => {
    e.preventDefault();
    setErrMsg("");

    // Validación de campos
    if (!nombreUsuario) {
      setErrMsg("Ingrese un usuario");
      return;
    }
    if (!contrasena) {
      setErrMsg("Ingrese una contraseña");
      return;
    }

    console.log("Nombre de usuario:", nombreUsuario);
    console.log("Contraseña:", contrasena);
    console.log(JSON.stringify({ nombre_usuario: nombreUsuario, contrasena }));

    try {
      const response = await fetch("http://localhost/project1/src/api/PDO/usuarios/api.php?apicall=login", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ nombre_usuario: nombreUsuario, contrasena }),
      });

      console.log("Response status:", response.status); // Verifica el estado de la respuesta

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const data = await response.json();
      console.log("Data received from API:", data); // Verifica los datos recibidos de la API

      if (data.error) {
        setErrMsg(data.message || "Error al iniciar sesión.");
      } else if (data.contenido) {
        // Guarda el nombre del usuario en localStorage
        localStorage.setItem("user", JSON.stringify(data.contenido));
        navigate("/home");
      } else {
        setErrMsg("Error desconocido al iniciar sesión.");
      }
    } catch (error) {
      setErrMsg(`Error al iniciar sesión: ${error.message}`);
      console.error("Error during login:", error);
    }
  };

  return (
    <div className="login-page">
      <div className="login-container">
        <div className="brand-section">
          <img src={logo} alt="Logo de la empresa" className="logo" />
        </div>
        <span>
          <a className="enlaces_inicio" href="/register">Regístrate</a>
        </span>
        <form onSubmit={handleLogin} className="login-form">
          <div className="input-group">
            <label>Usuario</label>
            <input
              type="text"
              name="nombre_usuario"
              placeholder="Nombre de usuario"
              value={nombreUsuario}
              onChange={(e) => setNombreUsuario(e.target.value)}
              autoComplete="off"
              className="box"
            />
          </div>

          <div className="input-group">
            <label>Contraseña</label>
            <input
              type="password"
              name="contrasena"
              placeholder="Contraseña"
              value={contrasena}
              onChange={(e) => setContrasena(e.target.value)}
              autoComplete="off"
              className="box"
            />
            <input  type="submit" value="Ingresar" className="login-btn" />
          </div>
        </form>
        <span>
          <a className="enlaces_inicio" href="/forgot">Olvidó la Contraseña</a>
        </span>
        <br />
        <span>
          <a className="enlaces_inicio" href="/">Volver al inicio</a>
        </span>

        {errMsg && (
          <div
            style={{ color: "#FF0000", textAlign: "center", fontSize: "17px" }}
          >
            {errMsg}
          </div>
        )}
      </div>
    </div>
  );
};

export default Login;
