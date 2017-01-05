#!/bin/bash
#
#BSUB -a poe                  # set parallel operating environment
#BSUB -J umrumeps[24-240:24]             # job name
#BSUB -W 06:00                # wall-clock time (hrs:mins)
#BSUB -n 16                   # number of tasks in job
#BUSB -x
#BSUB -R span[ptile=16]
#BSUB -R rusage[mem=61440]
#BSUB -q small             	  # queue
#BSUB -e um2grb2.fcst.00hr.err.%J.hybrid     # error file name in which %J is replaced by the job ID
#BSUB -o um2grb2.fcst.00hr.out.%J.hybrid     # output file name in which %J is replaced by the job ID

# find out the directory of this bash script after submitted to bsub
DIR="$( cd "$( dirname "${BASH_SOURCE[1]}" )" && pwd )"

# get the absolute path of the local table 
localTable=/gpfs2/home/arulalan/UMRiderUsr/UMRRun/tables/local/ncmr/v1/ncmr_grib2_local_table

# get the absolute path of the script for forecast 00utc
g2script=/gpfs2/home/arulalan/UMRiderUsr/UMRRun/g2scripts/umeps2grb2_fcst_00Z.py

# export the configure paths to needed variables
export UMRIDER_SETUP=$DIR/umr_setup.cfg
export UMRIDER_VARS=$DIR/umr_vars.cfg
export GRIB2TABLE=$localTable

echo "export UMRIDER_SETUP="$UMRIDER_SETUP
echo "export UMRIDER_VARS="$UMRIDER_VARS
echo "export GRIB2TABLE="$GRIB2TABLE

# sourcing umtid_bashrc to load module python-uvcdat-iris!
source "$DIR/umrider_bashrc"
# execute the script
export SHELL=/bin/bash
# get the hour to pass command line argument (from based on JOB index)
hour=$(printf "%02d" ${LSB_JOBINDEX})     # 2-digit number starting with 0
echo "hour="${hour}
# execute the script
python $g2script --start_long_fcst_hour=${hour} --end_long_fcst_hour=${hour}

