/*!

=========================================================
* Light Bootstrap Dashboard React - v1.3.0
=========================================================

* Product Page: https://www.creative-tim.com/product/light-bootstrap-dashboard-react
* Copyright 2019 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://github.com/creativetimofficial/light-bootstrap-dashboard-react/blob/master/LICENSE.md)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

*/
import React, { Component } from "react";
import { NavItem, Nav } from "react-bootstrap";

class AdminNavbarLinks extends Component {
  _logout (event) {
    event.preventDefault();
    localStorage.clear();
    window.location.href = '/';
  }

  render() {
    return (
      <div>
        <Nav pullRight>
          <NavItem eventKey={1} href="#" onClick={this._logout}>
            <p>
              <i className="pe-7s-back-2"></i>&nbsp;
              Log out
            </p>
          </NavItem>
        </Nav>
      </div>
    );
  }
}

export default AdminNavbarLinks;
