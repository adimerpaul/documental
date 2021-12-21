import Login from "pages/Login";
import Recepcion from "pages/Recepcion";
import User from "pages/User";
import Seguimiento from "pages/Seguimiento";
import Asignacion from "pages/Asignacion";
import Misrecepciones from "pages/Misrecepciones";
import Categoria from "pages/Categoria";
import Documento from "pages/Documento";
import Reportegraf from "pages/Reportegraf";
import Impresion from "pages/Impresion";
import Solicitarprestamo from "pages/Solicitarprestamo";
import Missolicitudes from "pages/Missolicitudes";
import Aceptarsolicitudes from "pages/Aceptarsolicitudes";

const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: Login },
      { path: '/recepcion', component: Recepcion,meta: {requiresAuth: true,} },
      { path: '/user', component: User,meta: {requiresAuth: true,} },
      { path: '/seguimiento', component: Seguimiento,meta: {requiresAuth: true,} },
      { path: '/asiganacion', component: Asignacion,meta: {requiresAuth: true,} },
      { path: '/misrecepciones', component: Misrecepciones,meta: {requiresAuth: true,} },
      { path: '/categoria', component: Categoria,meta: {requiresAuth: true,} },
      { path: '/documento', component: Documento,meta: {requiresAuth: true,} },
      { path: '/reportegraf', component: Reportegraf,meta: {requiresAuth: true,} },
      { path: '/impresion', component: Impresion,meta: {requiresAuth: true,} },
      { path: '/solicitarprestamo', component: Solicitarprestamo,meta: {requiresAuth: true,} },
      { path: '/missolicitudes', component: Missolicitudes,meta: {requiresAuth: true,} },
      { path: '/aceptarsolicitudes', component: Aceptarsolicitudes,meta: {requiresAuth: true,} },
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/Error404.vue')
  }
]

export default routes
