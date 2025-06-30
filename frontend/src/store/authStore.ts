import { create } from 'zustand';
import { AuthState } from '../interfaces/auth';
import { UserLogged } from '../interfaces/user';

export const useAuthStore = create<AuthState>((set) => ({
  user: null,
  loading: false,
  error: null,
  setUser: (user: UserLogged | null) => set({ user }),
  setLoading: (loading: boolean) => set({ loading }),
  setError: (error: string | null) => set({ error }),
}));