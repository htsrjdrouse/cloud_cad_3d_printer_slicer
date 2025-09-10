<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Three.js STL Loader Example</title>
    <style>
        body {
            margin: 0;
            overflow: hidden;
        }
        canvas {
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/three@0.132.2/build/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.132.2/examples/js/loaders/STLLoader.js"></script>
    <script>
        // Set up the scene, camera, and renderer
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer();
        renderer.setSize(window.innerWidth, window.innerHeight);
        document.body.appendChild(renderer.domElement);

        // Load the STL file
        const loader = new THREE.STLLoader();
        loader.load('uploads/washbowl_8tip_base.stl', function (geometry) {
            const material = new THREE.MeshPhongMaterial({color: 0xff5533, specular: 0x111111, shininess: 200});
            const mesh = new THREE.Mesh(geometry, material);
            mesh.position.set(0, 0, 0);
            mesh.scale.set(0.01, 0.01, 0.01);
            scene.add(mesh);
        });

        // Add lighting to the scene
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
        scene.add(ambientLight);
        const directionalLight = new THREE.DirectionalLight(0xffffff, 0.5);
        directionalLight.position.set(0, 1, 1);
        scene.add(directionalLight);

        // Set up the camera position
        camera.position.set(0, 0, 3);
        camera.lookAt(scene.position);

        // Render the scene
        function animate() {
            requestAnimationFrame(animate);
            renderer.render(scene, camera);
        }
        animate();
    </script>
</body>
</html>
