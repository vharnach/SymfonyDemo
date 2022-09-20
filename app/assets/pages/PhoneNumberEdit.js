import React, { useState, useEffect } from 'react';
import { Link, useParams } from "react-router-dom";
import Layout from "../components/Layout"
import Swal from 'sweetalert2'
import axios from 'axios';

function PhoneNumberEdit() {
    const [id, setId] = useState(useParams().id)
    const [phoneNumber, setPhoneNumber] = useState('');
    const [isSaving, setIsSaving] = useState(false)


    useEffect(() => {
        axios.get(`/api/phone-number/${id}`)
        .then(function (response) {
            let contact = response.data
            setPhoneNumber(contact.phoneNumber);
        })
        .catch(function (error) {
            Swal.fire({
                icon: 'error',
                title: 'An Error Occured!' + error,
                showConfirmButton: false,
                timer: 1500
            })
        })

    }, [])


    const handleSave = () => {
        setIsSaving(true);
        axios.patch(`/api/phone-number/${id}`, {
            phoneNumber: phoneNumber
        })
        .then(function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Project updated successfully!',
                showConfirmButton: false,
                timer: 1500
            })
            setIsSaving(false);
        })
        .catch(function (error) {
            Swal.fire({
                icon: 'error',
                title: 'An Error Occured!',
                showConfirmButton: false,
                timer: 1500
            })
            setIsSaving(false)
        });
    }


    return (
        <Layout>
            <div className="container">
                <h2 className="text-center mt-5 mb-3">Edit Project</h2>
                <div className="card">
                    <div className="card-header">
                        <Link
                            className="btn btn-outline-info float-right"
                            to="/">View All Projects
                        </Link>
                    </div>
                    <div className="card-body">
                        <form>
                            <div className="form-group">
                                <label htmlFor="phoneNumber">Name</label>
                                <input
                                    onChange={(event)=>{setPhoneNumber(event.target.value)}}
                                    value={phoneNumber}
                                    type="text"
                                    className="form-control"
                                    id="phoneNumber"
                                    phoneNumber="phoneNumber"/>
                            </div>
                            <button
                                disabled={isSaving}
                                onClick={handleSave}
                                type="button"
                                className="btn btn-outline-success mt-3">
                                Update Project
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </Layout>
    );
}

export default PhoneNumberEdit;