import { lazy, Suspense, useEffect, useState } from "react";
import {
  Route,
  createBrowserRouter,
  createRoutesFromElements,
  RouterProvider,
} from "react-router-dom";

import ErrorBoundary from "./components/ErrorBoundary";
import NavbarSidebarLayout from "./components/layouts/NavbarSidebarLayout";
import BasicLayout from "./components/layouts/BasicLayout";

import { checkAuth } from "./actions/AuthActions";
import UserGroup from "./pages/UserGroup";
import PrivateRoute from "./components/PrivateRoute";

const HomePage = lazy(() => import("./pages/Home"));
const ResourcePage = lazy(() => import("./pages/Resources"));
const GroupsPage = lazy(() => import("./pages/Groups"));
const ServicesPage = lazy(() => import("./pages/Services"));
const AdminPanelPage = lazy(() => import("./pages/AdminPanel"));
const LoginPage = lazy(() => import("./pages/Login"));
const TraceLLM = lazy(() => import("./pages/TraceLLM"));

const Loader = () => <div>Cargando...</div>;

const routesFromElements = createRoutesFromElements(
  <>
    <Route element={<NavbarSidebarLayout />}>
      <Route
        index
        element={ 
          <PrivateRoute>
            <Suspense fallback={<Loader />}>
              <HomePage />
            </Suspense>
          </PrivateRoute>
        }
      />
      <Route
        path="/resources"
        element={
          <PrivateRoute>
            <Suspense fallback={<Loader />}>
              <ResourcePage />
            </Suspense>
          </PrivateRoute>
        }
        errorElement={<ErrorBoundary />}
      />
      <Route
        path="/groups"
        element={
          <PrivateRoute>
            <Suspense fallback={<Loader />}>
              <GroupsPage />
            </Suspense>
          </PrivateRoute>
        }
        errorElement={<ErrorBoundary />}
      />
      <Route
        path="/services"
        element={
          <PrivateRoute>
            <Suspense fallback={<Loader />}>
              <ServicesPage />
            </Suspense>
          </PrivateRoute>
        }
        errorElement={<ErrorBoundary />}
      />
      <Route
        path="/visor"
        element={
          <PrivateRoute>
            <Suspense fallback={<Loader />}>
              <TraceLLM />
            </Suspense>
          </PrivateRoute>
        }
        errorElement={<ErrorBoundary />}
      />
      <Route
        path="/user-group"
        element={
          <PrivateRoute>
            <Suspense fallback={<Loader />}>
              <UserGroup/>
            </Suspense>
          </PrivateRoute>
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
        path="/login"
        element={
          <Suspense fallback={<Loader />}>
            <LoginPage />
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

  const [isReady, setReady] = useState(false);
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    if (!isReady && !loading) {
      setLoading(true);
      checkAuth()
        .finally(() => {
          setReady(true);
          setLoading(false);
        });
    }
  }, [isReady, loading]);

  if (!isReady) {
    return <div>Loading...</div>;
  }
  return <RouterProvider router={router} />;
};

export default App;