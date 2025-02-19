import { useAuthStore } from '../store/authStore';
import { loginService, Credentials } from '../services/authService';

export const login = async (credentials: Credentials) => {
  const { setLoading, setError, setUser } = useAuthStore.getState();
  setLoading(true);
  setError(null);
  try {
    const data = await loginService(credentials);
    if (data.user) {
      setUser(data.user);
    } else {
      setError(data.error || 'Authentication failed');
    }
  } catch (err: unknown) {
    const errorMessage = err instanceof Error ? err.message : 'Error unknown';
    setError(errorMessage);
  } finally {
    setLoading(false);
  }
};

export const logout = () => {
  const { setUser } = useAuthStore.getState();
  setUser(null);
};