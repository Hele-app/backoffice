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
import Dashboard from "views/Dashboard.jsx";
import IndexYoungs from "views/youngs/Index.jsx";
import IndexPros from "views/pros/Index.jsx";
import Poi from "views/poi/Poi.jsx";
import IndexAdviceCard from "views/advice_card/Index.jsx";
import IndexArticle from "views/article/Index.jsx";

const dashboardRoutes = [
  {
    path: "/dashboard",
    name: "Dashboard",
    icon: "pe-7s-graph",
    component: Dashboard,
    layout: "/admin"
  },
  {
    path: "/youngs",
    name: "Jeunes",
    icon: "pe-7s-users",
    component: IndexYoungs,
    layout: "/admin"
  },
  {
    path: "/pros",
    name: "Professionnels",
    icon: "pe-7s-id",
    component: IndexPros,
    layout: "/admin"
  },
  {
    path: "/poi",
    name: "Points d'intérêts",
    icon: "pe-7s-global",
    component: Poi,
    layout: "/admin"
  },
  {
    path: "/advicecards",
    name: "Fiches Conseils",
    icon: "pe-7s-note2",
    component: IndexAdviceCard,
    layout: "/admin"
  },
  {
    path: "/articles",
    name: "Articles",
    icon: "pe-7s-news-paper",
    component: IndexArticle,
    layout: "/admin"
  }
];

export default dashboardRoutes;
