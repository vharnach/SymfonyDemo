import React, {useState, useEffect} from 'react';
import { Link, useParams } from "react-router-dom";
import Layout from "../components/Layout"
import axios from 'axios';

function PhoneNumberShow() {
    const [id, setId] = useState(useParams().id)
    const [contact, setContact] = useState({phoneNumber:''})
    useEffect(() => {
        axios.get(`/api/phone-number/${id}`)
        .then(function (response) {
            setContact(response.data)
        })
        .catch(function (error) {
            console.log(error);
        })
    }, [])

    return (
        <Layout>
            <div className="container">
                <h2 className="text-center mt-5 mb-3">Show Phone Number</h2>
                <div className="card">
                    <div className="card-header">
                        <Link
                            className="btn btn-outline-info float-right"
                            to="/"> View All Phone Numbers
                        </Link>
                    </div>
                    <div className="card-body">
                        <b className="text-muted">Id:</b>
                        <p>{contact.id}</p>
                        <b className="text-muted">Phone number:</b>
                        <p>{contact.phoneNumber}</p>
                    </div>
                </div>
            </div>
        </Layout>
    );
}

export default PhoneNumberShow;
