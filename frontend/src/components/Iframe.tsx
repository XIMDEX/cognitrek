export default function Iframe({src, title, style={}}) {
    return (
        <iframe src={src} title={title} style={{border: 'none', ...style}}></iframe>
    )
}