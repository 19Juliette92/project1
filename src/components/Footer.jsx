import React from 'react';
import '../styles/Footer.css';
import { FaFacebookF, FaInstagram, FaYoutube, FaTwitter, FaLinkedinIn, FaMediumM } from 'react-icons/fa';

const Footer = () => {
    return (
        <footer className="pie-de-pagina">
            <div className="iconos-sociales">
                <a href="https://facebook.com" target="_blank" rel="noopener noreferrer"><FaFacebookF /></a>
                <a href="https://instagram.com" target="_blank" rel="noopener noreferrer"><FaInstagram /></a>
                <a href="https://youtube.com" target="_blank" rel="noopener noreferrer"><FaYoutube /></a>
                <a href="https://twitter.com" target="_blank" rel="noopener noreferrer"><FaTwitter /></a>
                <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer"><FaLinkedinIn /></a>
            </div>
            <div className="contenido-pie">
                <p>&copy; 2023 Intelligate</p>
            </div>
        </footer>
    );
};

export default Footer;
