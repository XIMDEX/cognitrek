import { XAvatar } from "@ximdex/xui-react/dist";

interface XAvatarProps {
    items: React.ReactNode[],
    email: string,
    username: string,
    image: string,
    size: 'sm' | 'md' | 'lg' | 'xl'
}

const Avatar = ({items, email, username, image, size='sm'}: XAvatarProps): JSX.Element => {
    return (
        <XAvatar 
            items={items} 
            email={email} 
            username={username}
            image={image}
            size={size}
        />
    )
} 

export default Avatar