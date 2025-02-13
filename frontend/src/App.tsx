import { lazy, Suspense } from "react";
import {
  Route,
  createBrowserRouter,
  createRoutesFromElements,
  RouterProvider,
} from "react-router-dom";

import ErrorBoundary from "./components/ErrorBoundary";
import NavbarSidebarLayout from "./components/layouts/NavbarSidebarLayout";
import BasicLayout from "./components/layouts/BasicLayout";

const HomePage = lazy(() => import("./pages/Home"));
const ResourcePage = lazy(() => import("./pages/Resources"));
const GroupsPage = lazy(() => import("./pages/Groups"));
const ServicesPage = lazy(() => import("./pages/Services"));
const AdminPanelPage = lazy(() => import("./pages/AdminPanel"));
const TraceLLM = lazy(() => import("./pages/TraceLLM"));

const Loader = () => <div>Cargando...</div>;

const routesFromElements = createRoutesFromElements(
  <>
    <Route element={<NavbarSidebarLayout />}>
      <Route
        index
        element={
          <Suspense fallback={<Loader />}>
            <HomePage />
          </Suspense>
        }
      />
      <Route
        path="/resources"
        element={
          <Suspense fallback={<Loader />}>
            <ResourcePage />
          </Suspense>
        }
        errorElement={<ErrorBoundary />}
      />
      <Route
        path="/groups"
        element={
          <Suspense fallback={<Loader />}>
            <GroupsPage />
          </Suspense>
        }
        errorElement={<ErrorBoundary />}
      />
      <Route
        path="/services"
        element={
          <Suspense fallback={<Loader />}>
            <ServicesPage />
          </Suspense>
        }
        errorElement={<ErrorBoundary />}
      />
      <Route
        path="/visor"
        element={
          <Suspense fallback={<Loader />}>
            <TraceLLM id={"232"} />
          </Suspense>
        }
        errorElement={<ErrorBoundary />}
      />
    </Route>

    <Route element={<BasicLayout />}>
      <Route
        index
        element={
          <Suspense fallback={<Loader />}>
            <HomePage />
          </Suspense>
        }
      />
      <Route
        path="/admin-panel"
        element={
          <Suspense fallback={<Loader />}>
            <AdminPanelPage />
          </Suspense>
        }
        errorElement={<ErrorBoundary />}
      />
    </Route>
  </>
);

const router = createBrowserRouter(routesFromElements);

const App = () => {
  return <RouterProvider router={router} />;
};

export default App;