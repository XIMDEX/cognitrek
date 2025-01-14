import {
  Route,
  createBrowserRouter,
  createRoutesFromElements,
  RouterProvider,
} from "react-router-dom";

import HomePage from "./pages/Home";
import ResourcePage from "./pages/Resources";

import ErrorBoundary from "./components/ErrorBoundary";
import NavbarSidebarLayout from "./components/layouts/NavbarSidebarLayout";
import BasicLayout from "./components/layouts/BasicLayout";
import GroupsPage from "./pages/Groups";
import ServicesPage from "./pages/Services";
import AdminPanelPage from "./pages/AdminPanel";

const routesFromElements = createRoutesFromElements(
  <>
    <Route element={<NavbarSidebarLayout />}>
      <Route index element={<HomePage />} />
      <Route
        path="/resources"
        element={<ResourcePage />}
        errorElement={<ErrorBoundary />}
      />
      <Route
        path="/groups"
        element={<GroupsPage />}
        errorElement={<ErrorBoundary />}
      />
      <Route
        path="/services"
        element={<ServicesPage />}
        errorElement={<ErrorBoundary />}
      />
    </Route>

    <Route element={<BasicLayout />}>
      <Route index element={<HomePage />} />
      <Route
        path="/admin-panel"
        element={<AdminPanelPage />}
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
