import Button  from "../components/ui/Button";
import { useEffect, useState } from "react";
import { useAuthStore } from "../store/authStore";
import { login } from "../actions/AuthActions";
import { useLocation, useNavigate } from "react-router-dom";

const LOGO_IMG = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTpaRZ2iX_qRa5HtyUH4YxshnC_LDbU9O5d9Q&s"

const SCREENS = {
    LOGIN: 'login',
    REGISTER: 'register',
    FORGOT_PASSWORD: 'forgot-password'
}

export default function Login() {
    const location = useLocation();
    const navigate = useNavigate();
    const {state} = location;
    const {user} = useAuthStore.getState();
    const [screen, setScreen] = useState(SCREENS.LOGIN);
    const { loading, error } = useAuthStore();
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');

    useEffect(() => {
        if (user && state?.from) {
            navigate(state.from);
        } 
        if (user && !state?.from) {
            navigate('/');
        }
            
    }, [user, state, navigate]);
  
    const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
      e.preventDefault();
      await login({ email, password });
    };

    const setScreenToLogin = () => {
        setScreen(SCREENS.LOGIN);
    }
    const setScreenToRegister = () => {
        setScreen(SCREENS.REGISTER);
    }
    const setScreenToForgotPassw = () => {
        setScreen(SCREENS.FORGOT_PASSWORD);
    }

    if (screen === SCREENS.REGISTER) {
        return (
            <section className="bg-secondary">
                Register form
                <Button onClick={setScreenToLogin}>Back</Button>
            </section>
        )
    }

    if (screen === SCREENS.FORGOT_PASSWORD) {
        return (
            <section className="bg-secondary">
                Forgot password form
                <Button onClick={setScreenToLogin}>Back</Button>
            </section>
        )
    }

    return (
        <section className="bg-secondary">
            <div className="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
                
                <div className="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
                    <div className="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1 className="flex items-center mb-6 text-5xl font-semibold text-slate-600 w-full justify-center py-6">
                            <img className="w-14 h-14 mr-2" src={LOGO_IMG} alt="logo"/>
                            Cognitrek
                        </h1>
                        <h2 className="text-2xl  leading-tight tracking-tight text-gray-900 md:text-2xl">
                            Sign in to your account
                        </h2>
                        <form className="space-y-4 md:space-y-6" action="#" onSubmit={handleSubmit}>
                            <div>
                                <label className="block mb-2 text-sm font-medium text-gray-900">
                                    Your email
                                    <input 
                                        type="email" 
                                        name="email" 
                                        id="email" 
                                        value={email}
                                        onChange={(e) => setEmail(e.target.value)}
                                        className="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" 
                                        placeholder="name@company.com" 
                                        required 
                                    />
                                </label>
                            </div>
                            <div>
                                <label className="block mb-2 text-sm font-medium text-gray-900">
                                    Password
                                    <input 
                                        type="password" 
                                        name="password" 
                                        id="password" 
                                        value={password}
                                        onChange={(e) => setPassword(e.target.value)}
                                        placeholder="••••••••" 
                                        className="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                        required 
                                    />
                                </label>
                            </div>
                            <div className="flex items-center justify-between">
                                <button 
                                    type="button"
                                    onClick={setScreenToForgotPassw} 
                                    className="text-sm font-medium text-primary-600 hover:underline "
                                >Forgot password?</button>
                            </div>
                            <Button 
                                type="submit" 
                                className="w-full" 
                                style={{maxWidth: '100%', marginBlock: 30}}
                                disabled={loading}
                            >{loading ? 'Loading...' : 'Sign in'}</Button>
                            <p className="text-sm font-light text-gray-500  text-right">
                                Don’t have an account yet? <button onClick={setScreenToRegister} className="border-0 font-medium text-primary-600 hover:underline">Sign up</button>
                            </p>
                        </form>
                        {error && <p style={{ color: 'red' }}>{error}</p>}
                    </div>
                </div>
            </div>
        </section>
    )
} 