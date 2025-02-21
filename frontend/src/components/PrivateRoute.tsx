import { useAuthStore } from '../store/authStore';
import { ROLES } from '../config/constants';
import { Navigate } from 'react-router-dom';

interface PrivateRouteProps {
  children: JSX.Element;
  isAdminPage?: boolean;
}

const PrivateRoute: React.FC<PrivateRouteProps> = ({ children, isAdminPage}) => {

  const user = useAuthStore((state) => state.user);


  if (isAdminPage && (user?.role == ROLES.ADMIN || user?.role == ROLES.SUPERADMIN)) {
    return children;
  } else {
    return user ? children : <Navigate to="/" />;
  }
};

export default PrivateRoute;