import React, {useState} from 'react';
import { Link } from "react-router-dom";
import Layout from "../components/Layout"
import Swal from 'sweetalert2'
import axios from 'axios';

function PhoneNumberCreate() {
    const [phoneNumber, setPhoneNumber] = useState('');
    const [isSaving, setIsSaving] = useState(false)

    const handleSave = () => {
        setIsSaving(true);
        axios.post('/api/phone-number', {
            phoneNumber: phoneNumber
        })
        .then(function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Phone number saved successfully!',
                showConfirmButton: false,
                timer: 1500
            })
            setIsSaving(false);
            setPhoneNumber('')
        })
        .catch(function (error) {
            Swal.fire({
                icon: 'error',
                title: 'An Error Occured!' + error,
                showConfirmButton: false,
                timer: 1500
            })
            setIsSaving(false)
        });
    }

    return (
        <Layout>
            <div className="container">
                <h2 className="text-center mt-5 mb-3">Create New Phone number</h2>
                <div className="card">
                    <div className="card-header">
                        <Link
                            className="btn btn-outline-info float-right"
                            to="/">View All Phone numbers
                        </Link>
                    </div>
                    <div className="card-body">
                        <form>
                            <div className="form-group">
                                <label htmlFor="phoneNumber">Phone number</label>
                                <input
                                    onChange={(event)=>{setPhoneNumber(event.target.value)}}
                                    value={phoneNumber}
                                    type="text"
                                    className="form-control"
                                    id="phoneNumber"
                                    name="phoneNumber"/>
                            </div>
                            <button
                                disabled={isSaving}
                                onClick={handleSave}
                                type="button"
                                className="btn btn-outline-primary mt-3">
                                Save Phone number
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </Layout>
    );
}

export default PhoneNumberCreate;