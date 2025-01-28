import React, { useState, useEffect } from 'react';
import $ from 'jquery';

const UserManager = () => {
    const [users, setUsers] = useState([]);
    const [error, setError] = useState(null);
    const [successMessage, setSuccessMessage] = useState(null);
    const [formData, setFormData] = useState({ name: '', email: '' });
    const [editingUserId, setEditingUserId] = useState(null);

    useEffect(() => {
        fetchUsers();
    }, []);

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData((prevData) => ({
            ...prevData,
            [name]: value,
        }));
    };

    const handleError = (err) => {
        if (err.responseJSON) {
            setError(err.responseJSON.data.error);
        } else {
            setError('An error occurred');
        }
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        const { name, email } = formData;
        setError(null);
        setSuccessMessage(null);

        if (!name || !email) {
            setError('Both name and email are required.');
            return;
        }

        if (editingUserId) {
            // Update existing user
            $.ajax({
                url: usertestAdmin.ajax_url,
                type: 'POST',
                data: {
                    action: 'tuupdate_user',
                    _ajax_nonce: usertestAdmin.nonce,
                    data: { id: editingUserId, name, email },
                },
                success: (response) => {
                    if (response.success) {
                        fetchUsers();
                        setFormData({ name: '', email: '' });
                        setEditingUserId(null);
                        setSuccessMessage('User updated successfully.');
                    } else {
                        setError(response.data.error);
                    }
                },
                error: handleError,
            });
        } else {
            $.ajax({
                url: usertestAdmin.ajax_url,
                type: 'POST',
                data: {
                    action: 'tuadd_user',
                    _ajax_nonce: usertestAdmin.nonce,
                    data: { name, email },
                },
                success: (response) => {
                    if (response.success) {
                        fetchUsers();
                        setFormData({ name: '', email: '' });
                        setSuccessMessage('User added successfully.');
                    } else {
                        setError(response.data.error);
                    }
                },
                error: handleError,
            });
        }
    };

    const fetchUsers = () => {
        $.ajax({
            url: usertestAdmin.ajax_url,
            type: 'POST',
            data: {
                action: 'tuget_users',
                _ajax_nonce: usertestAdmin.nonce,
            },
            success: (response) => {
                if (response.success) {
                    setUsers(response.data);
                } else {
                    setError(response.data.error);
                }
            },
            error: handleError,
        });
    };

    const editUser = (user) => {
        setEditingUserId(user.id);
        setFormData({ name: user.name, email: user.email });
        setError(null);
        setSuccessMessage(null);
    };

    const deleteUser = (id) => {
        $.ajax({
            url: usertestAdmin.ajax_url,
            type: 'POST',
            data: {
                action: 'tudelete_user',
                _ajax_nonce: usertestAdmin.nonce,
                id,
            },
            success: (response) => {
                if (response.success) {
                    fetchUsers();
                    setSuccessMessage('User deleted successfully.');
                } else {
                    setError(response.data.error);
                }
            },
            error: handleError,
        });
    };

    const sendMail = (user) => {
        $.ajax({
            url: usertestAdmin.ajax_url,
            type: 'POST',
            data: {
                action: 'tusend_mail',
                _ajax_nonce: usertestAdmin.nonce,
                data: { name: user.name, email: user.email },
            },
            success: (response) => {
                if (response.success) {
                    setSuccessMessage(`Mail sent to ${user.name} (${user.email}).`);
                } else {
                    setError(response.data.error);
                }
            },
            error: handleError,
        });
    };

    return (
        <div style={{ maxWidth: '900px', margin: '0 auto', padding: '20px' }}>
            <h1 style={{ textAlign: 'center', fontSize: '2rem', marginBottom: '20px' }}>User Manager</h1>

            {/* Success Message */}
            {successMessage && (
                <div
                    style={{
                        padding: '15px',
                        backgroundColor: '#d4edda',
                        color: '#155724',
                        borderRadius: '5px',
                        fontSize: '1rem',
                        marginBottom: '20px',
                    }}
                >
                    {successMessage}
                </div>
            )}

            {/* Error Message */}
            {error && (
                <div
                    style={{
                        padding: '15px',
                        backgroundColor: '#f8d7da',
                        color: '#721c24',
                        borderRadius: '5px',
                        fontSize: '1rem',
                        marginBottom: '20px',
                    }}
                >
                    {error}
                </div>
            )}

            {/* User Form */}
            <form
                onSubmit={handleSubmit}
                style={{
                    display: 'flex',
                    gap: '15px',
                    backgroundColor: '#f9f9f9',
                    padding: '20px',
                    borderRadius: '8px',
                    boxShadow: '0 2px 10px rgba(0, 0, 0, 0.1)',
                    marginBottom: '20px',
                }}
            >
                <div>
                    <label>Name:</label>
                    <input
                        type="text"
                        name="name"
                        value={formData.name}
                        onChange={handleChange}
                        placeholder="Enter Name"
                        style={{
                            padding: '10px',
                            border: '1px solid #ccc',
                            borderRadius: '5px',
                            fontSize: '1rem',
                            width: '200px',
                        }}
                    />
                </div>
                <div>
                    <label>Email:</label>
                    <input
                        type="email"
                        name="email"
                        value={formData.email}
                        onChange={handleChange}
                        placeholder="Enter Email"
                        style={{
                            padding: '10px',
                            border: '1px solid #ccc',
                            borderRadius: '5px',
                            fontSize: '1rem',
                            width: '200px',
                        }}
                    />
                </div>
                <button
                    type="submit"
                    style={{
                        padding: '10px 20px',
                        backgroundColor: '#007bff',
                        color: 'white',
                        border: 'none',
                        borderRadius: '5px',
                        fontSize: '1rem',
                        cursor: 'pointer',
                    }}
                >
                    {editingUserId ? 'Update User' : 'Add User'}
                </button>
            </form>

            {/* User List */}
            <h2 style={{ marginTop: '30px' }}>Users List</h2>
            {users.length === 0 ? (
                <div
                    style={{
                        padding: '10px',
                        backgroundColor: '#f8f9fa',
                        textAlign: 'center',
                        fontSize: '1rem',
                        color: '#6c757d',
                    }}
                >
                    No data available
                </div>
            ) : (
                <table style={{ width: '100%', borderCollapse: 'collapse', marginTop: '20px' }}>
                    <thead>
                        <tr style={{ backgroundColor: '#f1f1f1' }}>
                            <th style={{ padding: '10px', textAlign: 'left', border: '1px solid #ddd' }}>Name</th>
                            <th style={{ padding: '10px', textAlign: 'left', border: '1px solid #ddd' }}>Email</th>
                            <th style={{ padding: '10px', textAlign: 'left', border: '1px solid #ddd' }}>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {users.map((user) => (
                            <tr key={user.id} style={{ backgroundColor: '#fff', borderBottom: '1px solid #ddd' }}>
                                <td style={{ padding: '10px' }}>{user.name}</td>
                                <td style={{ padding: '10px' }}>{user.email}</td>
                                <td style={{ padding: '10px' }}>
                                    <button
                                        onClick={() => sendMail(user)}
                                        style={{
                                            backgroundColor: '#28a745',
                                            color: 'white',
                                            padding: '5px 10px',
                                            borderRadius: '5px',
                                            cursor: 'pointer',
                                            marginRight: '10px',
                                        }}
                                    >
                                        Send Mail
                                    </button>
                                    <button
                                        onClick={() => editUser(user)}
                                        style={{
                                            backgroundColor: '#17a2b8',
                                            color: 'white',
                                            padding: '5px 10px',
                                            borderRadius: '5px',
                                            cursor: 'pointer',
                                            marginRight: '10px',
                                        }}
                                    >
                                        Edit
                                    </button>
                                    <button
                                        onClick={() => deleteUser(user.id)}
                                        style={{
                                            backgroundColor: '#dc3545',
                                            color: 'white',
                                            padding: '5px 10px',
                                            borderRadius: '5px',
                                            cursor: 'pointer',
                                        }}
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            )}
        </div>
    );
};

export default UserManager;