import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import PhoneNumberList from "./pages/PhoneNumberList"
import PhoneNumberCreate from "./pages/PhoneNumberCreate"
import PhoneNumberEdit from "./pages/PhoneNumberEdit"
import PhoneNumberShow from "./pages/PhoneNumberShow"

function Main() {
    return (
        <Router>
            <Routes>
                <Route exact path="/"  element={<PhoneNumberList/>} />
                <Route path="/create"  element={<PhoneNumberCreate/>} />
                <Route path="/edit/:id"  element={<PhoneNumberEdit/>} />
                <Route path="/show/:id"  element={<PhoneNumberShow/>} />
            </Routes>
        </Router>
    );
}

export default Main;

if (document.getElementById('app')) {
    ReactDOM.render(<Main />, document.getElementById('app'));
}