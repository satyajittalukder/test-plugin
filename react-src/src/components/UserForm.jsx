import React, { useState, useEffect } from "react";

const UserForm = () => {
  const [users, setUsers] = useState([]);
  const [formData, setFormData] = useState({ id: "", name: "", email: "" });
  const [loading, setLoading] = useState(true);
  console.log(usertestAdmin);
  const fetchUsers = async () => {
    setLoading(true);
    try {
      const response = await fetch(ajaxurl, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          action: "get_users",
          _ajax_nonce: usertestAdmin.nonce,
        }),
      });

      if (!response.ok) {
        throw new Error("Failed to fetch users");
      }

      const data = await response.json();
      setUsers(data);
    } catch (error) {
      console.error("Failed to fetch users:", error);
    }
    setLoading(false);
  };

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const response = await fetch(ajaxurl, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          action: formData.id ? "update_user" : "add_user",
          data: formData,
          _ajax_nonce: usertestAdmin.nonce,
        }),
      });

      if (!response.ok) {
        throw new Error("Failed to submit user data");
      }

      await response.json();
      fetchUsers();
      setFormData({ id: "", name: "", email: "" });
    } catch (error) {
      console.error("Failed to submit user data:", error);
    }
  };

  const handleDelete = async (id) => {
    try {
      const response = await fetch(ajaxurl, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          action: "delete_user",
          id,
          _ajax_nonce: usertestAdmin.nonce,
        }),
      });

      if (!response.ok) {
        throw new Error("Failed to delete user");
      }

      await response.json();
      fetchUsers();
    } catch (error) {
      console.error("Failed to delete user:", error);
    }
  };

  useEffect(() => {
    fetchUsers();
  }, []);

  return (
    <div>
      <h1>User Management</h1>

      {/* Form Section */}
      <form onSubmit={handleSubmit}>
        <input
          type="text"
          name="name"
          placeholder="Name"
          value={formData.name}
          onChange={handleInputChange}
        />
        <input
          type="email"
          name="email"
          placeholder="Email"
          value={formData.email}
          onChange={handleInputChange}
        />
        <button type="submit">
          {formData.id ? "Update User" : "Add User"}
        </button>
      </form>

      {/* Data Loading State */}
      {loading ? (
        <p>Loading data...</p>
      ) : users.length === 0 ? (
        // No Data Available Message
        <p>Sorry, there is no data available.</p>
      ) : (
        // Display Users
        <ul>
          {users.map((user) => (
            <li key={user.id}>
              {user.name} - {user.email}
              <button onClick={() => setFormData(user)}>Edit</button>
              <button onClick={() => handleDelete(user.id)}>Delete</button>
            </li>
          ))}
        </ul>
      )}
    </div>
  );
};

export default UserForm;
