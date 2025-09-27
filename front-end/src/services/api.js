// src/services/api.js
/*

  Servicio para interactuar con la API del backend
  Utiliza fetch para hacer solicitudes HTTP, esta ruta base puede cambiar según tu configuración de entorno
  equivale a la ruta que definiste en el archivo .env de laravel

*/
const API_BASE_URL = import.meta.env.PUBLIC_API_URL || 'http://localhost:3000/api';

export class ApiService {
  static async request(endpoint, options = {}) {
    const url = `${API_BASE_URL}${endpoint}`;

    const config = {
      headers: {
        'Content-Type': 'application/json',
        ...options.headers,
      },
      ...options,
    };

    if (config.body && typeof config.body === 'object') {
      config.body = JSON.stringify(config.body);
    }

    try {
      const response = await fetch(url, config);

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      return await response.json();
    } catch (error) {
      console.error('API Error:', error);
      throw error;
    }
  }

  // Métodos específicos para tu API
  static async getUsuarios() {
    return this.request('/usuarios');
  }

  static async getUsuario(id) {
    return this.request(`/usuarios/${id}`);
  }

  static async updateUsuario(id, data) {
    return this.request(`/asignaciones/${id}`, {
      method: 'PUT',
      body: data,
    });
  }
  static async deleteUsuario(id) {
    return this.request(`/usuarios/${id}`, {
      method: 'DELETE',
    });
  }

  static async getRoles() {
    return this.request('/catalogos/roles');
  }

  static async getCarreras() {
    return this.request('/catalogos/carreras');
  }

  // Nuevos métodos para gestión de estado
  static async getInactiveUsuarios() {
    return this.request('/usuarios/usuarios-inactivos');
  }

  static async getAllUsuarios() {
    return this.request('/usuarios/usuarios-todos');
  }

  static async restoreUsuario(id) {
    return this.request(`/usuarios/${id}/restore`, {
      method: 'PATCH',
    });
  }
}
