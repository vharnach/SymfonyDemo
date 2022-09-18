import React,{ useState, useEffect} from 'react';
import { Link } from "react-router-dom";
import Layout from "../components/Layout"
import Swal from 'sweetalert2'
import axios from 'axios';

function PhoneNumberList() {
    const  [phoneNumberList, setPhoneNumberList] = useState([])

    useEffect(() => {
        fetchPhoneNumberList()
    }, [])

    const fetchPhoneNumberList = () => {
        axios.get('/api/phone-number')
        .then(function (response) {
            setPhoneNumberList(response.data);
        })
        .catch(function (error) {
            console.log(error);
        })
    }

    const handleDelete = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete(`/api/phone-number/${id}`)
                .then(function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Phone number deleted successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    fetchPhoneNumberList()
                })
                .catch(function (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'An Error Occured!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                });
            }
        })
    }

    return (
        <Layout>
            <div className="container">
                <h2 className="text-center mt-5 mb-3">Symfony Phone number Manager</h2>
                <div className="card">
                    <div className="card-header">
                        <Link
                            className="btn btn-outline-primary"
                            to="/create">Add New Phone number
                        </Link>
                    </div>
                    <div className="card-body">

                        <table className="table table-bordered">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Phone number</th>
                                <th width="240px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            {phoneNumberList.map((contact, key)=>{
                                return (
                                    <tr key={key}>
                                        <td>{contact.id}</td>
                                        <td>{contact.phoneNumber}</td>
                                        <td>
                                            <Link
                                                to={`/show/${contact.id}`}
                                                className="btn btn-outline-info mx-1">
                                                Show
                                            </Link>
                                            <Link
                                                className="btn btn-outline-success mx-1"
                                                to={`/edit/${contact.id}`}>
                                                Edit
                                            </Link>
                                            <button
                                                onClick={()=>handleDelete(contact.id)}
                                                className="btn btn-outline-danger mx-1">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                )
                            })}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </Layout>
    );
}

export default PhoneNumberList;