# HTS LabBot - Cloud CAD 3D Printer Slicer

**A PHP-based web application designed to visualize STL files, edit in SCAD and CSG, and slice and edit G-code for custom 3D printing routines**

## Overview

HTS LabBot is a comprehensive web-based CAD tool that revolutionizes your 3D printing workflow. Built on PHP with Apache server infrastructure, this platform integrates OpenSCAD and JSCAD technologies to provide a complete browser-based 3D design and printing pipeline without requiring any software installation.

## 🚀 Key Features

### **Instant Visualization**
- Real-time STL file viewing and manipulation
- Interactive 3D model preview with JSCAD rendering
- Cross-platform compatibility through web browsers

### **No Installation Required**
- Access powerful CAD tools directly from your browser
- Cloud-based processing eliminates hardware limitations
- Automatic updates and feature rollouts

### **Advanced Editing Capabilities**
- **OpenSCAD Integration**: Script-based parametric modeling
- **CSG Operations**: Boolean operations for complex geometries
- **STL Processing**: Import, modify, and export STL files with automatic conversion
- **G-code Editor**: Fine-tune printing parameters and paths with comprehensive analysis

### **Professional Slicing Integration**
- Full Slic3r integration with configurable profiles
- G-code generation with advanced customization options
- Detailed print analytics including filament usage and time estimation

### **Seamless Workflow Integration**
- From design conception to 3D printing output
- Custom slicing algorithms for optimized printing
- Multi-mode interface for different workflow stages

## 🛠 Technology Stack

- **Backend**: PHP with Apache web server
- **Command-line Tools**: 
  - **Node.js and npm**: JavaScript runtime for JSCAD CLI
  - **@jscad/cli**: JSCAD command-line interface for STL conversion
  - **slic3r**: Professional G-code generation engine
- **Frontend**: Bootstrap 4 responsive framework with jQuery
- **CAD Engines**: 
  - JSCAD (JavaScript CAD) with real-time rendering
  - OpenSCAD scripting integration
- **File Processing**: 
  - Multi-format upload system with validation
  - Server-side file conversion pipeline using Node.js tools
- **Session Management**: PHP sessions for project persistence
- **Data Storage**: JSON-based project and configuration management
- **3D Visualization**: Browser-based 3D model rendering

## 📋 Supported File Formats & Processing Pipeline

### Input Formats
- **STL Files**: Binary and ASCII STL files (up to 5MB)
  - Automatic validation and size checking
  - Server-side conversion to JSCAD format
- **JSCAD Scripts**: JavaScript-based CAD files
- **Project Files**: JSON-based project management

### Processing Pipeline
1. **STL Upload** → **JSCAD Conversion**: Uses server-side `jscad` command-line tool
2. **JSCAD Editing** → **STL Rendering**: Real-time model generation
3. **STL Files** → **G-code Generation**: Slic3r integration for slicing
4. **G-code Analysis**: Filament calculation, print time estimation, layer analysis

### Output Formats
- **STL**: Rendered 3D models ready for printing
- **G-code**: Printer-ready instruction files with comprehensive statistics
- **JSCAD**: Editable parametric design scripts

## 🎛 Application Modes

### **STL Management Mode** (`views=1`)
- **File Upload**: Drag-and-drop STL files with validation
- **Automatic Conversion**: Server-side STL to JSCAD conversion using command-line tools
- **Project Integration**: Files automatically added to project JSON structure
- **File Size Limits**: 5MB maximum upload size with safety checks

### **Code Editor Mode** (`views=0`)
- **Interactive JSCAD Editing**: Live code editing with syntax support
- **Real-time Preview**: Instant 3D visualization of code changes
- **File Management**: Direct editing of JSCAD scripts
- **Multi-directory Support**: Access files from both `uploads/` and `openscads/` directories

### **Slicer Management Mode** (`views=2`)
- **Slic3r Integration**: Professional slicing engine with configurable profiles
- **Configuration Management**: Save and load custom slicer configurations
- **G-code Generation**: Convert STL models to printer-ready G-code
- **Print Analytics**: 
  - Filament volume calculations (cm³)
  - Filament length estimation (mm)
  - Print time predictions
  - Layer-by-layer analysis
- **G-code Inspection**: Line-by-line G-code examination and editing

### **OpenSCAD Mode** (`views=3`)
- **OpenSCAD Integration**: Full OpenSCAD scripting support
- **Parametric Design**: Variable-driven 3D modeling
- **Advanced Geometry**: CSG operations and complex mathematical modeling

## 🔧 Installation & Setup

### Server Requirements
- **Apache Web Server** with PHP support
- **PHP 7.4+** with session support and file upload enabled
- **Command-line Tools**:
  - **Node.js and npm**: Required for JSCAD CLI installation
  - **@jscad/cli**: JSCAD command-line tool for STL to JSCAD conversion
  - **slic3r**: Professional G-code generation engine
  - **sudo** permissions for file operations
- **Directory Structure**:
  - `uploads/` - STL and JSCAD file storage (writable)
  - `openscads/` - OpenSCAD script storage
  - `rendered/` - Generated STL files
  - `rendered/gcodes/` - Generated G-code files
  - `slic3r/` - Slicer configurations and management

### Quick Setup
```bash
# Clone the repository
git clone https://github.com/htsrjdrouse/cloud_cad_3d_printer_slicer.git

# Move to web server directory
sudo cp -r cloud_cad_3d_printer_slicer/ /var/www/html/

# Set proper permissions
sudo chown -R www-data:www-data /var/www/html/cloud_cad_3d_printer_slicer/
sudo chmod -R 755 /var/www/html/cloud_cad_3d_printer_slicer/

# Ensure upload directories are writable
sudo chmod 777 /var/www/html/cloud_cad_3d_printer_slicer/uploads/
sudo chmod 777 /var/www/html/cloud_cad_3d_printer_slicer/rendered/
sudo chmod 777 /var/www/html/cloud_cad_3d_printer_slicer/rendered/gcodes/
```

### Install Dependencies

#### 1. Install Node.js and npm
```bash
# For Ubuntu/Debian systems
curl -fsSL https://deb.nodesource.com/setup_lts.x | sudo -E bash -
sudo apt-get install -y nodejs

# Verify installation
node --version
npm --version

# Alternative: Install via snap
sudo snap install node --classic
```

#### 2. Install JSCAD CLI Tool
```bash
# Install JSCAD command-line interface globally
sudo npm install -g @jscad/cli

# Verify JSCAD installation
jscad --version

# Test JSCAD functionality
jscad --help
```

#### 3. Install Slic3r
```bash
# For Ubuntu/Debian
sudo apt-get update
sudo apt-get install slic3r

# For other systems, download from https://slic3r.org/
# or compile from source

# Verify Slic3r installation
slic3r --version
```

### Troubleshooting Installation

#### Node.js/JSCAD Issues
```bash
# If you get permission errors with npm global install
sudo npm install -g @jscad/cli --unsafe-perm=true --allow-root

# Alternative: Use npx to run without global install
npx @jscad/cli --version

# Check if JSCAD is in PATH
which jscad
echo $PATH
```

#### Slic3r Issues
```bash
# If Slic3r package not found, try alternative installation
sudo apt-get install prusa-slicer
# or
wget https://github.com/prusa3d/PrusaSlicer/releases/latest

# For older systems, compile from source
git clone https://github.com/slic3r/Slic3r.git
cd Slic3r
perl Build.PL
perl Build.PL --gui
sudo ./Build install
```

#### File Permission Issues
```bash
# If web server can't execute commands
sudo usermod -a -G sudo www-data

# Test command execution as www-data
sudo -u www-data jscad --version
sudo -u www-data slic3r --version
```

### Configuration
- Configure Slic3r profiles through the management interface
- Set up project permissions in `projects.json`
- Adjust file upload limits in PHP configuration if needed

### For End Users
1. Navigate to the web application URL
2. Start a new project or upload existing STL files
3. Switch between different modes using the interface buttons
4. Use the integrated 3D viewer to visualize your designs
5. Generate G-code with detailed analytics
6. Download optimized files for printing

## 🏗 Application Architecture

### Core Components

#### **Main Application (index.php)**
- Session management and user state persistence
- Multi-mode view controller with POST-based navigation
- Bootstrap-responsive interface with integrated navigation
- File upload handling and project management

#### **Module Structure**
```
├── index.php                 # Main application controller
├── jscadlib.php             # JSCAD library integration
├── uploadfile.php           # File upload processing with STL validation
├── slicer_management.php    # Slic3r integration and G-code generation
├── example.3dviewer.caller.inc.php  # 3D visualization controller
├── example.openscad.code.editor.php # OpenSCAD editor interface
├── example.objects.json.php # Object management API
├── projects.json            # Project data storage
└── slic3r/                  # Slicer configuration management
    ├── slic3rconfigfiles.json
    └── slic3rconfig_management.php
```

#### **Session-Based State Management**
- `$_SESSION['opensaveproject']`: Project authorization
- `$_SESSION['views']`: Current application mode (0-3)
- `$_SESSION['jscadfilename']`: Active design file
- `$_SESSION['jscadcontents']`: Current file content
- `$_SESSION['directory']`: Working directory path
- `$_SESSION['selectedproject']`: Current project identifier
- `$_SESSION['configactive']`: Active Slic3r configuration

### File Processing Workflow
1. **Upload**: STL files validated and stored in `uploads/`
2. **Conversion**: Command-line `jscad` (Node.js) converts STL to JSCAD format
3. **Editing**: Browser-based JSCAD code editor with live preview
4. **Rendering**: JSCAD scripts generate STL files in `rendered/`
5. **Slicing**: Slic3r processes STL files into G-code with analytics
6. **Analysis**: G-code parsed for filament usage, print time, and layer data

## 🎯 Use Cases

### **Rapid Prototyping**
- Upload STL files and immediately start editing as JSCAD scripts
- Quick design iterations with real-time 3D preview
- Collaborative design reviews through web interface

### **Educational Applications**
- Learn parametric modeling with JSCAD scripting
- Understand G-code generation and 3D printing workflows
- No software licensing concerns for institutions

### **Professional Workflows**
- Complete STL to G-code pipeline with professional slicing
- Custom printer profiles and material configurations
- Detailed print analytics for cost estimation and optimization

### **Maker Community**
- Accessible tools for hobbyists and enthusiasts
- Web-based interface eliminates installation barriers
- Support for various printer types through Slic3r integration

## 📊 Performance & Analytics

### **File Processing**
- STL files up to 5MB supported
- Automatic STL to JSCAD conversion via Node.js command-line tools
- Real-time 3D rendering in browser

### **G-code Analytics**
- **Filament Usage**: Volume (cm³) and length (mm) calculations
- **Print Time**: Accurate time estimation based on G-code analysis
- **Layer Analysis**: Z-level breakdown for print inspection
- **File Position Tracking**: Line-by-line G-code navigation

### **Session Management**
- Persistent project state across browser sessions
- Multi-project support with JSON-based storage
- Configuration profiles saved and reloadable

## 🎛 Configuration

### **Slic3r Integration**
- Multiple configuration profiles supported
- JSON-based configuration management
- Web interface for profile selection and management
- Custom settings for different printers and materials

### **Project Management**
- JSON-based project storage (`projects.json`)
- File organization by project
- Automatic file association and tracking

## 🔒 Security & File Handling

- **File Validation**: STL file format validation with regex patterns
- **Size Limits**: 5MB maximum upload size to prevent abuse
- **Permission Management**: Proper file ownership and permissions
- **Session Security**: PHP session-based access control
- **Directory Isolation**: Organized file storage in separate directories

## 🆘 Support & Troubleshooting

### **Common Issues**
- **File Upload Errors**: Check file size limits and directory permissions
- **Conversion Failures**: Ensure `jscad` CLI tool is properly installed with Node.js
- **Slicing Issues**: Verify Slic3r installation and configuration files
- **Permission Errors**: Check `sudo` access for file operations
- **Node.js Issues**: Verify Node.js and npm are properly installed and accessible

### **System Requirements**
- Modern web browser with JavaScript enabled
- Apache server with PHP 7.4+ and file upload support
- Node.js and npm for JSCAD CLI tools
- Command-line access for tool installation

### **Community Support**
- [GitHub Issues](https://github.com/htsrjdrouse/cloud_cad_3d_printer_slicer/issues)
- [Discussion Forum](https://github.com/htsrjdrouse/cloud_cad_3d_printer_slicer/discussions)

### **Commercial Support**
- Custom integration services
- Priority technical support
- Training and consultation
- Contact: [support@htsresources.com](mailto:support@htsresources.com)

## 🤝 Contributing

We welcome contributions from the community! Whether you're fixing bugs, adding features, or improving documentation, your help is appreciated.

### How to Contribute
1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Guidelines
- Follow existing PHP coding standards
- Test file upload and conversion workflows
- Ensure proper file permissions in development
- Verify Node.js tools are accessible from PHP exec() calls
- Update documentation for new features

## 📈 Roadmap

### Version 2.0 (Q4 2025)
- [ ] Multi-material printing support in Slic3r integration
- [ ] Advanced G-code editing with syntax highlighting
- [ ] Real-time collaboration on JSCAD projects
- [ ] Enhanced print simulation and preview

### Version 3.0 (Q2 2026)
- [ ] AI-powered slicing optimization
- [ ] Integration with cloud printing services
- [ ] Advanced mesh repair and optimization
- [ ] Mobile-responsive interface improvements

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- **Node.js** community for the JavaScript runtime environment
- **JSCAD** project for JavaScript-based CAD capabilities and CLI tools
- **OpenSCAD** community for the powerful scripting engine
- **Slic3r** developers for the professional slicing engine
- The broader 3D printing community for inspiration and feedback
- Contributors and beta testers who helped shape this platform

## 📞 Contact

**HTS Resources**
- Website: [https://htsresources.com](https://htsresources.com)
- Email: [info@htsresources.com](mailto:info@htsresources.com)
- GitHub: [@htsrjdrouse](https://github.com/htsrjdrouse)

---

*Experience the future of CAD design – try our cloud-based tool today and transform the way you approach 3D printing.*
