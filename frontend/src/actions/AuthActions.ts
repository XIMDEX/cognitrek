import { useAuthStore } from '../store/authStore';
import { loginService, logoutService } from '../services/authService';
import { Credentials } from '../interfaces/auth';
import { whoamiService } from '../services/userService';

export const login = async (credentials: Credentials) => {
  const { setLoading, setError, setUser } = useAuthStore.getState();
  setLoading(true);
  setError(null);
  try {
    const data = await loginService(credentials);
    if (data.user) {
      setUser(data.user);
      localStorage.setItem('JWT', data.user.token);
      sessionStorage.setItem('JWT', data.user.token);
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

export const logout = async () => {
  const { setUser, user } = useAuthStore.getState();
  try {
    await logoutService(user);
  } catch (err: unknown) {
    console.error(err);
  } finally {
    await globalThis.cookieStore.delete('JWT');
    localStorage.removeItem('JWT');
    sessionStorage.removeItem('JWT');
    setUser(null);
  }

};

export const checkAuth = async () => {
  const token = localStorage.getItem('JWT') ?? sessionStorage.getItem('JWT') ?? (await globalThis.cookieStore.get('JWT'))?.value;
  const { setUser, user } = useAuthStore.getState();

  if (token) {
    const response = await whoamiService(token);
    if (response) {
      setUser(response);
    } else {
      setUser(null)
      localStorage.removeItem('JWT');
      sessionStorage.removeItem('JWT');
    }
  }
  return !!user;
} 