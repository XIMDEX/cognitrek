
interface ImageProps {
    src: string;
    alt: string;
    className?: string;
    width?: number;
    height?: number;
    onClick?: () => void;
}

export default function Image({src, alt, className, width, height, onClick}: ImageProps) {
    return (
        <img 
            src={src} 
            alt={alt} 
            className={className} 
            onClick={onClick}
            width={width}
            height={height}
        />
    )
}
